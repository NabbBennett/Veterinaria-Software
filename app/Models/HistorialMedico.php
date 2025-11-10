<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;

    protected $table = 'historial_medico';

    protected $fillable = [
        'paciente_id',
        'user_id',
        'fecha',
        'tipo',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'temperatura',
        'peso'
    ];

    protected $casts = [
        'fecha' => 'date',
        'temperatura' => 'decimal:2',
        'peso' => 'decimal:2',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}