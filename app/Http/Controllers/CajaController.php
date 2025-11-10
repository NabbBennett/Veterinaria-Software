<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\ServicioRealizado;
use App\Models\Servicio;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CajaController extends Controller
{

    public function index()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            $productos = Producto::where('activo', true)->where('stock', '>', 0)->get();
            $pacientes = Paciente::where('activo', true)->get();
            
            // CAMBIO IMPORTANTE: Cargar servicios disponibles en lugar de servicios realizados
            $servicios = Servicio::where('activo', true)->get();
            
            return view('admin.dashboard.caja', compact('productos', 'servicios', 'pacientes'));

        } catch (\Exception $e) {
            \Log::error('Error en CajaController@index: ' . $e->getMessage());
            
            // Cargar vista con datos mínimos
            $productos = Producto::where('activo', true)->where('stock', '>', 0)->get();
            $pacientes = Paciente::where('activo', true)->get();
            $servicios = collect(); // Colección vacía para servicios
            
            return view('admin.dashboard.caja', compact('productos', 'servicios', 'pacientes'));
        }
    }

    public function create()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            $productos = Producto::where('activo', true)->where('stock', '>', 0)->get();
            $serviciosRealizados = ServicioRealizado::with(['servicio', 'paciente'])
                ->where('estado', 'completado')
                ->whereNull('venta_id')
                ->get();
            $pacientes = Paciente::where('activo', true)->get();
            $servicios = Servicio::where('activo', true)->get();
            
            return view('admin.dashboard.caja-create', compact(
                'productos', 
                'serviciosRealizados', 
                'pacientes', 
                'servicios'
            ));

        } catch (\Exception $e) {
            Log::error('Error en CajaController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        DB::beginTransaction();

        try {
            $items = json_decode($request->items, true);
            $userId = Session::get('user_id');
            
            if (empty($items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay artículos en la venta.'
                ], 422);
            }

            // Calcular totales
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['subtotal'];
            }

            // Crear venta
            $venta = Venta::create([
                'user_id' => $userId,
                'paciente_id' => $request->paciente_id ?: null,
                'fecha' => now()->format('Y-m-d'),
                'subtotal' => $subtotal,
                'descuento' => 0,
                'total' => $subtotal,
                'tipo_pago' => $request->tipo_pago,
                'estado' => 'completada',
                'notas' => 'Venta registrada desde caja'
            ]);

            // Crear detalles de venta
            foreach ($items as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['tipo'] === 'producto' ? $item['producto_id'] : null,
                    'servicio_id' => $item['tipo'] === 'servicio' ? $item['servicio_id'] : null,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal']
                ]);

                // Actualizar stock si es producto
                if ($item['tipo'] === 'producto') {
                    $producto = Producto::find($item['producto_id']);
                    if ($producto) {
                        $producto->decrement('stock', $item['cantidad']);
                        
                        // Verificar stock mínimo
                        if ($producto->stock <= $producto->stock_minimo) {
                            Log::warning("Producto {$producto->nombre} ha alcanzado stock mínimo: {$producto->stock}");
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada exitosamente.',
                'venta_id' => $venta->id,
                'ticket_url' => route('admin.dashboard.caja.ticket', $venta->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en CajaController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reporte()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            // CORREGIDO: usar detalleVentas en lugar de detalles
            $ventas = Venta::with(['detalleVentas.producto', 'detalleVentas.servicio', 'paciente', 'user'])
                ->orderBy('fecha', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $totalVentas = $ventas->sum('total');
            $ventasHoy = Venta::whereDate('fecha', today())->sum('total');
            
            return view('admin.dashboard.caja-reporte', compact('ventas', 'totalVentas', 'ventasHoy'));

        } catch (\Exception $e) {
            Log::error('Error en CajaController@reporte: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el reporte: ' . $e->getMessage());
        }
    }
    
    public function mostrarTicket($venta_id)
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            // CORREGIDO: usar detalleVentas en lugar de detalles
            $venta = Venta::with([
                'detalleVentas.producto', 
                'detalleVentas.servicio',
                'paciente',
                'user'
            ])->findOrFail($venta_id);

            // CORREGIDO: ruta correcta de la vista
            return view('admin.dashboard.caja.ticket-completo', compact('venta'));

        } catch (\Exception $e) {
            Log::error('Error al mostrar ticket completo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al mostrar el ticket: ' . $e->getMessage());
        }
    }

    /**
     * Generar ticket de venta para impresión
     */
    public function generarTicket($venta_id)
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            // CORREGIDO: usar detalleVentas en lugar de detalles
            $venta = Venta::with([
                'detalleVentas.producto', 
                'detalleVentas.servicio',
                'paciente',
                'user'
            ])->findOrFail($venta_id);

            // CORREGIDO: ruta correcta de la vista
            return view('admin.dashboard.caja.ticket-impresion', compact('venta'));

        } catch (\Exception $e) {
            Log::error('Error al generar ticket: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el ticket: ' . $e->getMessage());
        }
    }

    /**
     * Descargar ticket en PDF
     */
    public function descargarTicketPDF($venta_id)
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            // CORREGIDO: usar detalleVentas en lugar de detalles
            $venta = Venta::with([
                'detalleVentas.producto', 
                'detalleVentas.servicio',
                'paciente',
                'user'
            ])->findOrFail($venta_id);

            // CORREGIDO: ruta correcta de la vista
            $pdf = Pdf::loadView('admin.dashboard.caja.ticket-pdf', compact('venta'));

            return $pdf->download('ticket-venta-' . $venta_id . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF del ticket: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Ver ticket en modal (para vista previa)
     */
    public function verTicket($venta_id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            // CORREGIDO: usar detalleVentas en lugar de detalles
            $venta = Venta::with([
                'detalleVentas.producto', 
                'detalleVentas.servicio',
                'paciente',
                'user'
            ])->findOrFail($venta_id);

            // CORREGIDO: ruta correcta de la vista
            $html = view('admin.dashboard.caja.ticket-modal', compact('venta'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cargar ticket modal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el ticket: ' . $e->getMessage()
            ], 500);
        }
    }
}