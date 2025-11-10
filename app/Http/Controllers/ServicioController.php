<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\ServicioRealizado;
use App\Models\Paciente;
use Illuminate\Support\Facades\Session;

class ServicioController extends Controller
{
    public function index()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $servicios = Servicio::where('activo', true)->get();
        $pacientes = Paciente::where('activo', true)->get();
        $serviciosRealizados = ServicioRealizado::with(['paciente', 'servicio', 'user'])
            ->orderBy('fecha_servicio', 'desc')
            ->get();

        return view('admin.dashboard.servicios', compact(
            'servicios',
            'pacientes',
            'serviciosRealizados'
        ));
    }

    public function storeServicio(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:500',
            'tipo' => 'required|in:estetica,consulta,cirugia'
        ]);

        $servicio = Servicio::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'requiere_padecimiento' => in_array($request->tipo, ['consulta', 'cirugia']),
            'requiere_receta' => in_array($request->tipo, ['consulta', 'cirugia'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Servicio creado exitosamente.',
            'servicio' => $servicio
        ]);
    }

    public function realizarServicio(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'fecha_servicio' => 'required|date',
            'observaciones' => 'nullable|string',
            'padecimiento' => 'nullable|string',
            'receta_medica' => 'nullable|string'
        ]);

        $servicio = Servicio::findOrFail($request->servicio_id);

        // Validar campos requeridos según el tipo de servicio
        if (in_array($servicio->tipo, ['consulta', 'cirugia'])) {
            if (empty($request->padecimiento)) {
                return response()->json([
                    'success' => false,
                    'error' => 'El campo padecimiento es requerido para este tipo de servicio.'
                ]);
            }
        }

        $servicioRealizado = ServicioRealizado::create([
            'paciente_id' => $request->paciente_id,
            'servicio_id' => $request->servicio_id,
            'user_id' => Session::get('user_id'),
            'fecha_servicio' => $request->fecha_servicio,
            'padecimiento' => $request->padecimiento,
            'receta_medica' => $request->receta_medica,
            'observaciones' => $request->observaciones,
            'costo_final' => $servicio->precio,
            'estado' => 'completado'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Servicio registrado exitosamente.',
            'servicio_realizado' => $servicioRealizado
        ]);
    }

    public function edit($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    }

    public function update(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:500',
            'tipo' => 'required|in:estetica,consulta,cirugia'
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'requiere_padecimiento' => in_array($request->tipo, ['consulta', 'cirugia']),
            'requiere_receta' => in_array($request->tipo, ['consulta', 'cirugia'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Servicio actualizado exitosamente.',
            'servicio' => $servicio
        ]);
    }

    public function destroy($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Servicio eliminado exitosamente.'
        ]);
    }
}