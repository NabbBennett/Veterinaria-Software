<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Usuario no encontrado.');
        }

        return view('admin.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        // Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'puesto' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'usuario' => 'required|string|max:50|unique:users,usuario,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user->update([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'puesto' => $request->puesto,
                'email' => $request->email,
                'usuario' => $request->usuario,
            ]);

            // Actualizar la sesión si el usuario cambió
            if ($user->usuario !== Session::get('user_usuario')) {
                Session::put('user_usuario', $user->usuario);
            }

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            \Log::warning('Intento de cambiar contraseña sin autenticación');
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión primero.'
            ], 401);
        }

        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            \Log::warning('Usuario no encontrado al intentar cambiar contraseña', ['user_id' => Session::get('user_id')]);
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        // Validación
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if ($validator->fails()) {
            \Log::warning('Errores de validación en cambio de contraseña', [
                'errors' => $validator->errors()->toArray(),
                'user_id' => $user->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            \Log::warning('Contraseña actual incorrecta', ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta.'
            ], 422);
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            \Log::info('Contraseña actualizada exitosamente', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar contraseña: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la contraseña: ' . $e->getMessage()
            ], 500);
        }
    }
}