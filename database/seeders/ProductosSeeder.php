<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            // MEDICINAS
            [
                'nombre' => 'Antipulgas NexGard para Perros',
                'descripcion' => 'Tableta masticable para control de pulgas y garrapatas en perros',
                'categoria' => 'medicina',
                'precio_compra' => 180.00,
                'precio_venta' => 280.00,
                'stock' => 25,
                'stock_minimo' => 5,
                'proveedor' => 'Merial',
                'activo' => true,
            ],
            [
                'nombre' => 'Desparasitante Drontal Plus',
                'descripcion' => 'Tableta para desparasitación interna en perros',
                'categoria' => 'medicina',
                'precio_compra' => 120.00,
                'precio_venta' => 190.00,
                'stock' => 30,
                'stock_minimo' => 8,
                'proveedor' => 'Bayer',
                'activo' => true,
            ],
            [
                'nombre' => 'Antiinflamatorio Rimadyl',
                'descripcion' => 'Medicamento antiinflamatorio para dolor articular',
                'categoria' => 'medicina',
                'precio_compra' => 150.00,
                'precio_venta' => 240.00,
                'stock' => 15,
                'stock_minimo' => 4,
                'proveedor' => 'Zoetis',
                'activo' => true,
            ],

            // VACUNAS
            [
                'nombre' => 'Vacuna Triple Felina',
                'descripcion' => 'Vacuna contra panleucopenia, calicivirus y rinotraqueitis',
                'categoria' => 'vacuna',
                'precio_compra' => 200.00,
                'precio_venta' => 350.00,
                'stock' => 40,
                'stock_minimo' => 10,
                'proveedor' => 'Merial',
                'activo' => true,
            ],
            [
                'nombre' => 'Vacuna Antirrábica',
                'descripcion' => 'Vacuna contra la rabia para perros y gatos',
                'categoria' => 'vacuna',
                'precio_compra' => 120.00,
                'precio_venta' => 220.00,
                'stock' => 35,
                'stock_minimo' => 8,
                'proveedor' => 'Zoetis',
                'activo' => true,
            ],

            // ALIMENTOS
            [
                'nombre' => 'Alimento Premium para Perros Adultos',
                'descripcion' => 'Alimento balanceado para perros adultos razas medianas',
                'categoria' => 'alimento',
                'precio_compra' => 450.00,
                'precio_venta' => 680.00,
                'stock' => 18,
                'stock_minimo' => 5,
                'proveedor' => 'Royal Canin',
                'activo' => true,
            ],
            [
                'nombre' => 'Alimento para Gatos Castrados',
                'descripcion' => 'Alimento especial para gatos esterilizados',
                'categoria' => 'alimento',
                'precio_compra' => 380.00,
                'precio_venta' => 550.00,
                'stock' => 22,
                'stock_minimo' => 6,
                'proveedor' => 'Purina Pro Plan',
                'activo' => true,
            ],

            // JUGUETES
            [
                'nombre' => 'Hueso de Goma para Perros',
                'descripcion' => 'Juguete dental para perros, ayuda a limpiar dientes',
                'categoria' => 'juguete',
                'precio_compra' => 85.00,
                'precio_venta' => 150.00,
                'stock' => 28,
                'stock_minimo' => 10,
                'proveedor' => 'Kong',
                'activo' => true,
            ],
            [
                'nombre' => 'Varita con Plumas para Gatos',
                'descripcion' => 'Juguete interactivo para gatos con plumas',
                'categoria' => 'juguete',
                'precio_compra' => 45.00,
                'precio_venta' => 90.00,
                'stock' => 35,
                'stock_minimo' => 12,
                'proveedor' => 'PetSafe',
                'activo' => true,
            ],

            // ACCESORIOS
            [
                'nombre' => 'Correa Retráctil para Perros',
                'descripcion' => 'Correa retráctil 5 metros, ideal para paseos',
                'categoria' => 'accesorio',
                'precio_compra' => 120.00,
                'precio_venta' => 220.00,
                'stock' => 20,
                'stock_minimo' => 6,
                'proveedor' => 'Flexi',
                'activo' => true,
            ],
            [
                'nombre' => 'Cama Ortopédica para Perros',
                'descripcion' => 'Cama ortopédica para perros mayores o con problemas articulares',
                'categoria' => 'accesorio',
                'precio_compra' => 650.00,
                'precio_venta' => 980.00,
                'stock' => 8,
                'stock_minimo' => 2,
                'proveedor' => 'OrthoPet',
                'activo' => true,
            ],

            // HIGIENE
            [
                'nombre' => 'Shampoo Antipulgas',
                'descripcion' => 'Shampoo medicinal para control de pulgas y garrapatas',
                'categoria' => 'higiene',
                'precio_compra' => 95.00,
                'precio_venta' => 160.00,
                'stock' => 25,
                'stock_minimo' => 8,
                'proveedor' => 'Veterinary Formula',
                'activo' => true,
            ],
            [
                'nombre' => 'Cepillo Dental para Mascotas',
                'descripcion' => 'Kit de higiene dental con cepillo y pasta dental',
                'categoria' => 'higiene',
                'precio_compra' => 75.00,
                'precio_venta' => 130.00,
                'stock' => 30,
                'stock_minimo' => 10,
                'proveedor' => 'Virbac',
                'activo' => true,
            ],

            // OTROS
            [
                'nombre' => 'Transportadora para Gatos',
                'descripcion' => 'Transportadora plástica para gatos y perros pequeños',
                'categoria' => 'otro',
                'precio_compra' => 320.00,
                'precio_venta' => 480.00,
                'stock' => 12,
                'stock_minimo' => 3,
                'proveedor' => 'PetMate',
                'activo' => true,
            ],
            [
                'nombre' => 'Bebedero Automático',
                'descripcion' => 'Bebedero automático con filtro, 2 litros de capacidad',
                'categoria' => 'otro',
                'precio_compra' => 280.00,
                'precio_venta' => 420.00,
                'stock' => 15,
                'stock_minimo' => 4,
                'proveedor' => 'Petsafe',
                'activo' => true,
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }

        $this->command->info('15 productos veterinarios creados exitosamente!');
    }
}