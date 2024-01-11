<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run()
    {

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'unit_price' => 100.00,
            'total_price' => 200.00,
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_price' => 50.00,
        ]);


    }
}
