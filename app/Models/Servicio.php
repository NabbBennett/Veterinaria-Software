<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'tipo',
        'requiere_padecimiento',
        'requiere_receta',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'requiere_padecimiento' => 'boolean',
        'requiere_receta' => 'boolean',
        'activo' => 'boolean',
    ];

    // Tipos de servicios
    const TIPOS = [
        'estetica' => 'Estética',
        'consulta' => 'Consulta General',
        'cirugia' => 'Cirugía'
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}