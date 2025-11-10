<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Venta;
use Illuminate\Support\Facades\Session;

class PacienteController extends Controller
{
    public function index()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $pacientes = Paciente::where('activo', true)->get();
        return view('admin.dashboard.pacientes', compact('pacientes'));
    }

    public function store(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'owner_name' => 'required|string|max:255',
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'telefono' => 'required|string|max:20'
        ]);

        $paciente = Paciente::create([
            'nombre' => $request->pet_name,
            'especie' => $request->species,
            'raza' => $request->breed,
            'edad' => $request->age,
            'propietario' => $request->owner_name,
            'telefono' => $request->telefono,
            'peso' => $request->weight
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paciente creado exitosamente.',
            'paciente' => $paciente
        ]);
    }

    public function show($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $paciente = Paciente::findOrFail($id);
        $historial = Cita::where('paciente_id', $id)
            ->with('paciente')
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'paciente' => $paciente,
            'historial' => $historial
        ]);
    }

    public function edit($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    public function update(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'owner_name' => 'required|string|max:255',
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'telefono' => 'required|string|max:20'
        ]);

        $paciente = Paciente::findOrFail($id);
        
        $paciente->update([
            'nombre' => $request->pet_name,
            'especie' => $request->species,
            'raza' => $request->breed,
            'edad' => $request->age,
            'propietario' => $request->owner_name,
            'telefono' => $request->telefono,
            'peso' => $request->weight
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paciente actualizado exitosamente.',
            'paciente' => $paciente
        ]);
    }

    public function destroy($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $paciente = Paciente::findOrFail($id);
        $paciente->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Paciente eliminado exitosamente.'
        ]);
    }
}