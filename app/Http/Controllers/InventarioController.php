<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;

class InventarioController extends Controller
{
    public function index()
    {
        if (!Session::get('user_authenticated')) {
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $productos = Producto::where('activo', true)->get();
        $productosBajos = Producto::where('stock', '<=', \DB::raw('stock_minimo'))->get();
        
        return view('admin.dashboard.inventario', compact('productos', 'productosBajos'));
    }

    public function store(Request $request)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0'
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_venta * 0.7, // 30% de ganancia
            'stock' => $request->stock,
            'stock_minimo' => $request->stock_minimo,
            'descripcion' => $request->descripcion,
            'proveedor' => $request->proveedor
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al inventario exitosamente.',
            'producto' => $producto
        ]);
    }

    public function edit($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0'
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'precio_venta' => $request->precio_venta,
            'descripcion' => $request->descripcion
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente.',
            'producto' => $producto
        ]);
    }

    public function destroy($id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $producto = Producto::findOrFail($id);
        $producto->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ]);
    }

    public function aumentarStock(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $producto = Producto::findOrFail($id);
        $producto->increment('stock');

        return response()->json([
            'success' => true,
            'message' => 'Stock aumentado exitosamente.',
            'nuevo_stock' => $producto->stock
        ]);
    }

    public function disminuirStock(Request $request, $id)
    {
        if (!Session::get('user_authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $producto = Producto::findOrFail($id);
        
        if ($producto->stock > 0) {
            $producto->decrement('stock');
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock disminuido exitosamente.',
            'nuevo_stock' => $producto->stock
        ]);
    }
}