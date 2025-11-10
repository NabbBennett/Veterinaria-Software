<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioRealizado extends Model
{
    use HasFactory;

    protected $table = 'servicios_realizados';

    protected $fillable = [
        'paciente_id',
        'servicio_id',
        'user_id',
        'fecha_servicio',
        'padecimiento',
        'receta_medica',
        'observaciones',
        'costo_final',
        'estado'
    ];

    protected $casts = [
        'fecha_servicio' => 'date',
        'costo_final' => 'decimal:2',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}