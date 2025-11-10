<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    /**
     * Muestra el formulario de login - SIN MIDDLEWARE
     */
    public function showLoginForm()
    {
        // Verificación MUY SIMPLE sin middleware
        if (!Session::get('admin_authenticated')) {
            return redirect()->route('admin.access')
                ->with('info', 'Primero necesitas verificar el acceso administrativo.');
        }

        return view('admin.login');
    }

    /**
     * Muestra el formulario de registro - SIN MIDDLEWARE
     */
    public function showRegisterForm()
    {
        // Verificación simple
        if (!Session::get('admin_authenticated')) {
            return redirect()->route('admin.access');
        }

        return view('admin.register');
    }

    /**
     * Procesa el login de usuarios
     */
    public function login(Request $request)
    {
        // Validación básica
        if (empty($request->usuario) || empty($request->password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Usuario y contraseña son requeridos');
        }

        // Buscar usuario
        $user = User::where('usuario', $request->usuario)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login exitoso
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->nombre);
            Session::put('user_puesto', $user->puesto);
            Session::put('user_authenticated', true);

            return redirect()->route('admin.dashboard')
                ->with('success', "¡Bienvenido {$user->nombre}!");
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Credenciales incorrectas');
    }

    /**
     * Procesa el registro de nuevos usuarios
     */
    public function register(Request $request)
    {
        try {
            // Validación manual simple
            if (empty($request->usuario) || empty($request->password)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Usuario y contraseña son requeridos');
            }

            // Crear usuario
            $user = User::create([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'puesto' => $request->puesto,
                'email' => $request->email,
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password),
                'activo' => true,
            ]);

            return redirect()->route('admin.login')
                ->with('success', 'Usuario registrado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Cierra sesión de usuario
     */
    public function logoutUser(Request $request)
    {
        Session::forget('user_id');
        Session::forget('user_name');
        Session::forget('user_puesto');
        Session::forget('user_authenticated');

        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada.');
    }
}