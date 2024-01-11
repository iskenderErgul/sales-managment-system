<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        Category::create([
            'name' => 'Elektronik',
            'description' => 'Elektronik ürün kategorisi',
        ]);

        Category::create([
            'name' => 'Giyim',
            'description' => 'Giyim ürün kategorisi',
        ]);


    }
}
