<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'peso',
        'propietario',
        'telefono',
        'alergias',
        'notas_medicas',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'peso' => 'decimal:2',
    ];

    // Relaciones
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function historiales()
    {
        return $this->hasMany(HistorialMedico::class);
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class);
    }
}