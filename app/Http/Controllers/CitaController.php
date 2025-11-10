<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function index()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            $citas = Cita::with(['paciente', 'servicio', 'user'])
                        ->orderBy('fecha')
                        ->orderBy('hora')
                        ->get();
            
            $citasHoy = Cita::whereDate('fecha', today())
                          ->with(['paciente', 'servicio'])
                          ->orderBy('hora')
                          ->get();
            
            $pacientes = Paciente::where('activo', true)->get();
            $servicios = Servicio::where('activo', true)->get();
            $veterinarios = User::where('activo', true)->get();
            
            return view('admin.dashboard.citas', compact('citas', 'citasHoy', 'pacientes', 'servicios', 'veterinarios'));

        } catch (\Exception $e) {
            Log::error('Error en CitaController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar las citas: ' . $e->getMessage());
        }
    }

    public function create()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            $pacientes = Paciente::where('activo', true)->get();
            $servicios = Servicio::where('activo', true)->get();
            $veterinarios = User::where('activo', true)->get();
            
            return view('admin.dashboard.citas-create', compact('pacientes', 'servicios', 'veterinarios'));

        } catch (\Exception $e) {
            Log::error('Error en CitaController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $adminId = Session::get('user_id');

        if (!$adminId) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo identificar al usuario actual.'
            ], 401);
        }

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'costo' => 'required|numeric|min:0'
        ]);

        try {
            // Verificar si ya existe una cita a la misma hora
            $citaExistente = Cita::where('fecha', $request->fecha)
                                ->where('hora', $request->hora)
                                ->where('user_id', $adminId)
                                ->first();

            if ($citaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'El veterinario ya tiene una cita programada para esta hora.'
                ], 422);
            }

            $cita = Cita::create([
                'paciente_id' => $request->paciente_id,
                'servicio_id' => $request->servicio_id,
                'user_id' => $adminId, 
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'costo' => $request->costo,
                'estado' => $request->estado ?? 'pendiente'
            ]);

            $cita->load(['paciente', 'servicio', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Cita creada exitosamente.',
                'cita' => $cita
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en CitaController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            $cita = Cita::with(['paciente', 'servicio', 'user'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'cita' => $cita
            ]);

        } catch (\Exception $e) {
            Log::error('Error en CitaController@show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            $cita = Cita::with(['paciente', 'servicio', 'user'])->findOrFail($id);
            $pacientes = Paciente::where('activo', true)->get();
            $servicios = Servicio::where('activo', true)->get();
            $veterinarios = User::where('activo', true)->get();
            
            return view('admin.dashboard.citas.editar', compact('cita', 'pacientes', 'servicios', 'veterinarios'))->render();
        
        } catch (\Exception $e) {
            Log::error('Error en CitaController@edit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el formulario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verModal($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            $cita = Cita::with(['paciente', 'servicio', 'user'])->findOrFail($id);
            
            // Retornar la vista renderizada
            return view('admin.dashboard.citas.ver', compact('cita'))->render();

        } catch (\Exception $e) {
            Log::error('Error en CitaController@verModal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los detalles: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión primero.'
                ], 401);
            }
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'user_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'costo' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string'
        ]);

        try {
            $cita = Cita::findOrFail($id);

            // Verificar conflicto de horarios (excluyendo la cita actual)
            $citaExistente = Cita::where('fecha', $request->fecha)
                                ->where('hora', $request->hora)
                                ->where('user_id', $request->user_id)
                                ->where('id', '!=', $id)
                                ->first();

            if ($citaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'El veterinario ya tiene una cita programada para esta hora.'
                ], 422);
            }

            $cita->update([
                'paciente_id' => $request->paciente_id,
                'servicio_id' => $request->servicio_id,
                'user_id' => $request->user_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'motivo' => $request->motivo,
                'costo' => $request->costo,
                'estado' => $request->estado,
                'diagnostico' => $request->diagnostico,
                'tratamiento' => $request->tratamiento
            ]);

            // Cargar relaciones actualizadas
            $cita->load(['paciente', 'servicio', 'user']);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cita actualizada exitosamente.',
                    'cita' => $cita
                ]);
            }

            return redirect()->route('admin.dashboard.citas')
                ->with('success', 'Cita actualizada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error en CitaController@update: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la cita: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al actualizar la cita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!Session::get('user_authenticated')) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión primero.'
                ], 401);
            }
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        try {
            $cita = Cita::findOrFail($id);
            $cita->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cita eliminada exitosamente.'
                ]);
            }

            return redirect()->route('admin.dashboard.citas')
                ->with('success', 'Cita eliminada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error en CitaController@destroy: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la cita: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }

    // Métodos para el calendario AJAX
    public function countCitas(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            $fecha = $request->query('fecha', today()->format('Y-m-d'));
            $count = Cita::whereDate('fecha', $fecha)->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Error en CitaController@countCitas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al contar citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function citasPorFecha(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        try {
            $fecha = $request->query('fecha', today()->format('Y-m-d'));
            
            Log::info("Buscando citas para fecha: " . $fecha);
            
            $citas = Cita::whereDate('fecha', $fecha)
                        ->with(['paciente', 'servicio', 'user'])
                        ->orderBy('hora')
                        ->get();

            Log::info("Citas encontradas: " . $citas->count());

            return response()->json([
                'success' => true,
                'citas' => $citas
            ]);

        } catch (\Exception $e) {
            Log::error('Error en CitaController@citasPorFecha: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function citasPorPaciente($pacienteId)
    {
        try {
            $citas = Cita::where('paciente_id', $pacienteId)
                        ->with(['servicio', 'user'])
                        ->orderBy('fecha', 'desc')
                        ->orderBy('hora', 'desc')
                        ->get();
            
            return response()->json([
                'success' => true,
                'citas' => $citas
            ]);

        } catch (\Exception $e) {
            Log::error('Error en CitaController@citasPorPaciente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las citas del paciente: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método adicional para cambiar estado de cita
    public function cambiarEstado(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada'
        ]);

        try {
            $cita = Cita::findOrFail($id);
            $cita->update(['estado' => $request->estado]);

            $cita->load(['paciente', 'servicio', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Estado de la cita actualizado exitosamente.',
                'cita' => $cita
            ]);

        } catch (\Exception $e) {
            Log::error('Error en CitaController@cambiarEstado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }
}