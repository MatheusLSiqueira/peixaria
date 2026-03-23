<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@peixaria.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Clientes
        $customers = [
            ['name' => 'João Silva', 'email' => 'joao@email.com'],
            ['name' => 'Maria Santos', 'email' => 'maria@email.com'],
            ['name' => 'Carlos Oliveira', 'email' => 'carlos@email.com'],
        ];

        foreach ($customers as $customer) {
            User::create(array_merge($customer, [
                'password' => Hash::make('password'),
                'role'     => 'cliente',
                'phone'    => '(41) 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'address'  => 'Rua das Flores, ' . rand(1, 999) . ', Matinhos - PR',
            ]));
        }

        // Produtos
        $products = [
            // Peixes
            ['name' => 'Robalo Fresco', 'category' => 'peixe', 'price' => 89.90, 'stock' => 15,
             'description' => 'Robalo fresco pescado no litoral do Paraná. Excelente para grelhar ou assar.'],
            ['name' => 'Tilápia do Nilo', 'category' => 'peixe', 'price' => 32.50, 'stock' => 30,
             'description' => 'Tilápia fresca, sabor suave e carne firme. Ideal para fritar ou cozinhar.'],
            ['name' => 'Dourado do Paraná', 'category' => 'peixe', 'price' => 75.00, 'stock' => 10,
             'description' => 'Dourado fresco de água doce. Carne saborosa, perfeito para churrasco.'],
            ['name' => 'Sardinha Fresca', 'category' => 'peixe', 'price' => 18.90, 'stock' => 50,
             'description' => 'Sardinhas frescas, ricas em ômega-3. Ótimas para grelhar com limão.'],
            ['name' => 'Atum Fresco (filé)', 'category' => 'peixe', 'price' => 120.00, 'stock' => 8,
             'description' => 'Filé de atum fresco de alta qualidade. Ideal para sashimi ou grelhado.'],
            ['name' => 'Salmão Norueguês (filé)', 'category' => 'peixe', 'price' => 145.00, 'stock' => 12,
             'description' => 'Filé de salmão importado, rico em ômega-3. Perfeito para sushi e grill.'],
            ['name' => 'Tainha Defumada', 'category' => 'peixe', 'price' => 55.00, 'stock' => 20,
             'description' => 'Tainha defumada artesanalmente no litoral paranaense.'],

            // Frutos do mar
            ['name' => 'Camarão Rosa (kg)', 'category' => 'fruto_do_mar', 'price' => 95.00, 'stock' => 25,
             'description' => 'Camarão rosa fresco, pescado no litoral do Paraná. Vendido por kg.'],
            ['name' => 'Lagosta (unidade)', 'category' => 'fruto_do_mar', 'price' => 210.00, 'stock' => 5,
             'description' => 'Lagosta fresca do Atlântico. Preço por unidade de aproximadamente 500g.'],
            ['name' => 'Ostra (dúzia)', 'category' => 'fruto_do_mar', 'price' => 48.00, 'stock' => 40,
             'description' => 'Ostras frescas cultivadas em Guaratuba. Vendidas por dúzia.'],
            ['name' => 'Lula (kg)', 'category' => 'fruto_do_mar', 'price' => 62.00, 'stock' => 18,
             'description' => 'Lula fresca limpa, pronta para fritar ou refogar.'],
            ['name' => 'Polvo (kg)', 'category' => 'fruto_do_mar', 'price' => 85.00, 'stock' => 10,
             'description' => 'Polvo fresco, perfeito para grelhado no azeite ou cozido.'],
            ['name' => 'Mexilhão (kg)', 'category' => 'fruto_do_mar', 'price' => 22.00, 'stock' => 35,
             'description' => 'Mexilhões frescos cultivados no litoral. Ótimos para risoto e paella.'],
            ['name' => 'Mariscos (kg)', 'category' => 'fruto_do_mar', 'price' => 28.00, 'stock' => 30,
             'description' => 'Mistura de mariscos frescos. Excelente para caldeirada e pirão.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
