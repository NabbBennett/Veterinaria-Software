<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insertar 25 pacientes de ejemplo
        DB::table('pacientes')->insert([
            [
                'nombre' => 'Max',
                'especie' => 'Perro',
                'raza' => 'Labrador Retriever',
                'edad' => 3,
                'peso' => 28.50,
                'propietario' => 'Carlos Rodríguez',
                'telefono' => '555-0101',
                'alergias' => 'Ninguna conocida',
                'notas_medicas' => 'Vacunación completa, control anual',
                'activo' => true
            ],
            [
                'nombre' => 'Luna',
                'especie' => 'Gato',
                'raza' => 'Siamés',
                'edad' => 2,
                'peso' => 4.20,
                'propietario' => 'María González',
                'telefono' => '555-0102',
                'alergias' => 'Alergia a ciertos antiparasitarios',
                'notas_medicas' => 'Esterilizada en 2023',
                'activo' => true
            ],
            [
                'nombre' => 'Rocky',
                'especie' => 'Perro',
                'raza' => 'Bulldog Francés',
                'edad' => 4,
                'peso' => 12.80,
                'propietario' => 'Ana Martínez',
                'telefono' => '555-0103',
                'alergias' => 'Problemas respiratorios',
                'notas_medicas' => 'Requiere cuidado especial en clima cálido',
                'activo' => true
            ],
            [
                'nombre' => 'Bella',
                'especie' => 'Perro',
                'raza' => 'Golden Retriever',
                'edad' => 5,
                'peso' => 30.00,
                'propietario' => 'Juan Pérez',
                'telefono' => '555-0104',
                'alergias' => 'Alergia al pollo',
                'notas_medicas' => 'Dieta especial sin pollo',
                'activo' => true
            ],
            [
                'nombre' => 'Simba',
                'especie' => 'Gato',
                'raza' => 'Persa',
                'edad' => 6,
                'peso' => 5.50,
                'propietario' => 'Laura Sánchez',
                'telefono' => '555-0105',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Control dental cada 6 meses',
                'activo' => true
            ],
            [
                'nombre' => 'Toby',
                'especie' => 'Perro',
                'raza' => 'Beagle',
                'edad' => 2,
                'peso' => 15.30,
                'propietario' => 'Pedro López',
                'telefono' => '555-0106',
                'alergias' => 'Alergia a picaduras de pulgas',
                'notas_medicas' => 'Uso constante de antiparasitarios',
                'activo' => true
            ],
            [
                'nombre' => 'Mimi',
                'especie' => 'Gato',
                'raza' => 'Mestizo',
                'edad' => 1,
                'peso' => 3.80,
                'propietario' => 'Sofía Ramírez',
                'telefono' => '555-0107',
                'alergias' => 'Ninguna conocida',
                'notas_medicas' => 'Rescatada, en proceso de socialización',
                'activo' => true
            ],
            [
                'nombre' => 'Thor',
                'especie' => 'Perro',
                'raza' => 'Pastor Alemán',
                'edad' => 4,
                'peso' => 35.20,
                'propietario' => 'Roberto Díaz',
                'telefono' => '555-0108',
                'alergias' => 'Problemas articulares',
                'notas_medicas' => 'Suplementos articulares recomendados',
                'activo' => true
            ],
            [
                'nombre' => 'Nala',
                'especie' => 'Gato',
                'raza' => 'Bengalí',
                'edad' => 3,
                'peso' => 4.80,
                'propietario' => 'Elena Castro',
                'telefono' => '555-0109',
                'alergias' => 'Alergia a productos de limpieza',
                'notas_medicas' => 'Muy activa, requiere enriquecimiento ambiental',
                'activo' => true
            ],
            [
                'nombre' => 'Rex',
                'especie' => 'Perro',
                'raza' => 'Rottweiler',
                'edad' => 6,
                'peso' => 42.00,
                'propietario' => 'Miguel Ángel Torres',
                'telefono' => '555-0110',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Control cardíaco anual recomendado',
                'activo' => true
            ],
            [
                'nombre' => 'Cleo',
                'especie' => 'Gato',
                'raza' => 'Egipcio',
                'edad' => 2,
                'peso' => 3.90,
                'propietario' => 'Isabel Fernández',
                'telefono' => '555-0111',
                'alergias' => 'Alergia a algunos antibióticos',
                'notas_medicas' => 'Pelo corto, cuidado especial en invierno',
                'activo' => true
            ],
            [
                'nombre' => 'Bruno',
                'especie' => 'Perro',
                'raza' => 'Boxer',
                'edad' => 5,
                'peso' => 28.70,
                'propietario' => 'David Herrera',
                'telefono' => '555-0112',
                'alergias' => 'Problemas dermatológicos',
                'notas_medicas' => 'Dieta hipoalergénica',
                'activo' => true
            ],
            [
                'nombre' => 'Lola',
                'especie' => 'Perro',
                'raza' => 'Chihuahua',
                'edad' => 7,
                'peso' => 2.80,
                'propietario' => 'Carmen Ruiz',
                'telefono' => '555-0113',
                'alergias' => 'Problemas dentales',
                'notas_medicas' => 'Limpieza dental anual requerida',
                'activo' => true
            ],
            [
                'nombre' => 'Oliver',
                'especie' => 'Gato',
                'raza' => 'Maine Coon',
                'edad' => 4,
                'peso' => 8.20,
                'propietario' => 'Javier Morales',
                'telefono' => '555-0114',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Cepillado diario recomendado',
                'activo' => true
            ],
            [
                'nombre' => 'Daisy',
                'especie' => 'Perro',
                'raza' => 'Dálmata',
                'edad' => 3,
                'peso' => 25.40,
                'propietario' => 'Patricia Vega',
                'telefono' => '555-0115',
                'alergias' => 'Alergia a algunos granos',
                'notas_medicas' => 'Dieta grain-free recomendada',
                'activo' => true
            ],
            [
                'nombre' => 'Milo',
                'especie' => 'Gato',
                'raza' => 'British Shorthair',
                'edad' => 5,
                'peso' => 6.10,
                'propietario' => 'Ricardo Ortega',
                'telefono' => '555-0116',
                'alergias' => 'Problemas de peso',
                'notas_medicas' => 'Control de peso mensual',
                'activo' => true
            ],
            [
                'nombre' => 'Zoe',
                'especie' => 'Perro',
                'raza' => 'Husky Siberiano',
                'edad' => 2,
                'peso' => 22.50,
                'propietario' => 'Andrea Silva',
                'telefono' => '555-0117',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Muy activa, requiere mucho ejercicio',
                'activo' => true
            ],
            [
                'nombre' => 'Ginger',
                'especie' => 'Gato',
                'raza' => 'Atigrado',
                'edad' => 8,
                'peso' => 4.50,
                'propietario' => 'Fernando Reyes',
                'telefono' => '555-0118',
                'alergias' => 'Artritis',
                'notas_medicas' => 'Medicación para dolor articular',
                'activo' => true
            ],
            [
                'nombre' => 'Apolo',
                'especie' => 'Perro',
                'raza' => 'Pitbull',
                'edad' => 4,
                'peso' => 26.80,
                'propietario' => 'Gabriela Mendoza',
                'telefono' => '555-0119',
                'alergias' => 'Alergia estacional',
                'notas_medicas' => 'Antihistamínicos en primavera',
                'activo' => true
            ],
            [
                'nombre' => 'Coco',
                'especie' => 'Perro',
                'raza' => 'Poodle',
                'edad' => 6,
                'peso' => 7.20,
                'propietario' => 'Oscar Navarro',
                'telefono' => '555-0120',
                'alergias' => 'Problemas oculares',
                'notas_medicas' => 'Limpieza ocular diaria',
                'activo' => true
            ],
            [
                'nombre' => 'Kiara',
                'especie' => 'Gato',
                'raza' => 'Ragdoll',
                'edad' => 3,
                'peso' => 5.60,
                'propietario' => 'Lucía Campos',
                'telefono' => '555-0121',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Temperamento muy dócil',
                'activo' => true
            ],
            [
                'nombre' => 'Rocco',
                'especie' => 'Perro',
                'raza' => 'Doberman',
                'edad' => 5,
                'peso' => 38.90,
                'propietario' => 'Héctor Guzmán',
                'telefono' => '555-0122',
                'alergias' => 'Problemas cardíacos',
                'notas_medicas' => 'Control cardíaco cada 6 meses',
                'activo' => true
            ],
            [
                'nombre' => 'Sasha',
                'especie' => 'Perro',
                'raza' => 'Cocker Spaniel',
                'edad' => 4,
                'peso' => 13.50,
                'propietario' => 'Natalia Paredes',
                'telefono' => '555-0123',
                'alergias' => 'Otitis recurrentes',
                'notas_medicas' => 'Limpieza auditiva semanal',
                'activo' => true
            ],
            [
                'nombre' => 'Felix',
                'especie' => 'Gato',
                'raza' => 'Sphynx',
                'edad' => 2,
                'peso' => 4.00,
                'propietario' => 'Raúl Solís',
                'telefono' => '555-0124',
                'alergias' => 'Piel sensible',
                'notas_medicas' => 'Baños regulares y protección solar',
                'activo' => true
            ],
            [
                'nombre' => 'Jack',
                'especie' => 'Perro',
                'raza' => 'Border Collie',
                'edad' => 3,
                'peso' => 20.10,
                'propietario' => 'Daniela Romero',
                'telefono' => '555-0125',
                'alergias' => 'Ninguna',
                'notas_medicas' => 'Muy inteligente, necesita estimulación mental',
                'activo' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};