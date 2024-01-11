<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'category_id' => 1,
            'name' => 'Laptop',
            'description' => 'Güçlü bir laptop',
            'price' => 1500.00,
            'stock_quantity' => 50,
        ]);

        Product::create([
            'category_id' => 1,
            'name' => 'T-Shirt',
            'description' => 'Siyah pamuk t-shirt',
            'price' => 20.00,
            'stock_quantity' => 100,
        ]);

    }
}
