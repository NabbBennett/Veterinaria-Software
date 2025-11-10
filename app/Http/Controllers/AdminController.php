<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Producto;
use App\Models\Venta;

class AdminController extends Controller
{
    public function showAccessForm()
    {
        return view('admin.index');
    }

    public function verifyAccess(Request $request)
    {
        if ($request->clave !== '1234') {
            return redirect()->back()
                ->withErrors(['clave' => 'Clave de acceso incorrecta'])
                ->withInput();
        }

        Session::put('admin_authenticated', true);
        Session::put('admin_authenticated_at', now());

        return redirect()->route('admin.login')
            ->with('success', '¡Acceso concedido! Ahora inicia sesión.');
    }

    public function dashboard()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        // Obtener datos reales de la base de datos
        $datos = [
            'total_pacientes' => Paciente::where('activo', true)->count(),
            'citas_hoy' => Cita::whereDate('fecha', today())->count(),
            'productos_bajos' => Producto::where('stock', '<=', DB::raw('stock_minimo'))->count(),
            'ingresos_hoy' => Venta::whereDate('fecha', today())->sum('total')
        ];

        return view('admin.dashboard', compact('datos'));
    }
}