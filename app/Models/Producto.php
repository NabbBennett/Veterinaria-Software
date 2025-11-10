<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'proveedor',
        'activo'
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // Categorías disponibles
    const CATEGORIAS = [
        'medicina' => 'Medicina',
        'vacuna' => 'Vacunas',
        'alimento' => 'Alimento',
        'juguete' => 'Juguetes',
        'accesorio' => 'Accesorios',
        'higiene' => 'Higiene',
        'otro' => 'Otro'
    ];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}