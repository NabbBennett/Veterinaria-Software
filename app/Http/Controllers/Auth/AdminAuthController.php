<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller{
    public function showLoginForm(){
        if (!Session::get('admin_authenticated')) {
            return redirect()->route('admin.access')
                ->with('info', 'Primero necesitas verificar el acceso administrativo.');
        }

        return view('admin.login');
    }

    public function showRegisterForm(){
        if (!Session::get('admin_authenticated')) {
            return redirect()->route('admin.access');
        }
        return view('admin.register');
    }


    public function login(Request $request){
        if (empty($request->usuario) || empty($request->password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Usuario y contraseña son requeridos');
        }

        $user = User::where('usuario', $request->usuario)->first();

        if ($user && Hash::check($request->password, $user->password)) {
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

    public function register(Request $request){
        try {
            if (empty($request->usuario) || empty($request->password)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Usuario y contraseña son requeridos');
            }

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

    public function logoutUser(Request $request){
        Session::forget('user_id');
        Session::forget('user_name');
        Session::forget('user_puesto');
        Session::forget('user_authenticated');

        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada.');
    }
}