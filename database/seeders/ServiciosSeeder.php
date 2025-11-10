<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    public function run()
    {
        $servicios = [
            // SERVICIOS DE CONSULTA GENERAL
            [
                'nombre' => 'Consulta General',
                'descripcion' => 'Consulta médica general para diagnóstico y tratamiento',
                'precio' => 500.00,
                'tipo' => 'consulta',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Consulta de Urgencia',
                'descripcion' => 'Atención médica inmediata para casos de emergencia',
                'precio' => 800.00,
                'tipo' => 'consulta',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Consulta de Especialidad',
                'descripcion' => 'Consulta con veterinario especialista',
                'precio' => 700.00,
                'tipo' => 'consulta',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ],

            // SERVICIOS DE ESTÉTICA
            [
                'nombre' => 'Baño y Corte',
                'descripcion' => 'Servicio completo de baño, corte y secado',
                'precio' => 400.00,
                'tipo' => 'estetica',
                'requiere_padecimiento' => false,
                'requiere_receta' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Corte de Uñas',
                'descripcion' => 'Corte y limado de uñas',
                'precio' => 150.00,
                'tipo' => 'estetica',
                'requiere_padecimiento' => false,
                'requiere_receta' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Limpieza Dental',
                'descripcion' => 'Limpieza dental profesional sin anestesia',
                'precio' => 600.00,
                'tipo' => 'estetica',
                'requiere_padecimiento' => false,
                'requiere_receta' => false,
                'activo' => true,
            ],
            [
                'nombre' => 'Limpieza de Oídos',
                'descripcion' => 'Limpieza profunda de oídos',
                'precio' => 200.00,
                'tipo' => 'estetica',
                'requiere_padecimiento' => false,
                'requiere_receta' => false,
                'activo' => true,
            ],

            // SERVICIOS DE CIRUGÍA
            [
                'nombre' => 'Esterilización',
                'descripcion' => 'Cirugía de esterilización para mascotas',
                'precio' => 1200.00,
                'tipo' => 'cirugia',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Cirugía Menor',
                'descripcion' => 'Procedimientos quirúrgicos menores',
                'precio' => 800.00,
                'tipo' => 'cirugia',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'Extracción Dental',
                'descripcion' => 'Extracción de piezas dentales',
                'precio' => 900.00,
                'tipo' => 'cirugia',
                'requiere_padecimiento' => true,
                'requiere_receta' => true,
                'activo' => true,
            ]
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }

        $this->command->info('10 servicios veterinarios creados exitosamente!');
    }
}