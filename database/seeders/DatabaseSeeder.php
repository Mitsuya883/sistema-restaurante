<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@restaurante.com',
            'password' => Hash::make('12345678'), // La contraseña es '12345678'
            'role' => 'admin',
        ]);

        // Mozo
        User::create([
            'name' => 'Juan (Mozo)',
            'email' => 'mozo@restaurante.com',
            'password' => Hash::make('12345678'),
            'role' => 'waiter',
        ]);

        // Cocina
        User::create([
            'name' => 'Jefe de Cocina',
            'email' => 'cocina@restaurante.com',
            'password' => Hash::make('12345678'),
            'role' => 'chef',
        ]);

        // CATEGORÍAS
        $catEntradas = Category::create(['name' => 'Entradas', 'image' => 'entradas.jpg']);
        $catFondos = Category::create(['name' => 'Platos de Fondo', 'image' => 'fondos.jpg']);
        $catBebidas = Category::create(['name' => 'Bebidas', 'image' => 'bebidas.jpg']);

        // Entradas
        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Ceviche Clásico',
            'price' => 25.00,
            'description' => 'Pescado fresco con limón y ají'
        ]);

        Product::create([
            'category_id' => $catEntradas->id,
            'name' => 'Papa a la Huancaína',
            'price' => 15.00,
            'description' => 'Papas con crema de ají amarillo'
        ]);

        // Fondos
        Product::create([
            'category_id' => $catFondos->id,
            'name' => 'Lomo Saltado',
            'price' => 35.00,
            'description' => 'Clásico lomo al jugo con papas fritas'
        ]);

        Product::create([
            'category_id' => $catFondos->id,
            'name' => 'Arroz con Pollo',
            'price' => 28.00,
            'description' => 'Arroz verde con culantro y presa de pollo'
        ]);

        Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Inka Cola 500ml',
            'price' => 5.00,
            'description' => 'La bebida del perú'
        ]);

        Table::create(['name' => 'Mesa 1', 'capacity' => 4, 'status' => 'libre']);
        Table::create(['name' => 'Mesa 2', 'capacity' => 4, 'status' => 'libre']);
        Table::create(['name' => 'Mesa 3', 'capacity' => 2, 'status' => 'libre']);
        Table::create(['name' => 'Mesa 4', 'capacity' => 6, 'status' => 'libre']);
        Table::create(['name' => 'Mesa 5', 'capacity' => 4, 'status' => 'libre']);
    }
}
