<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'servicio_id', 
        'user_id',
        'fecha',
        'hora',
        'motivo',
        'costo',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo' => 'decimal:2',
    ];

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}