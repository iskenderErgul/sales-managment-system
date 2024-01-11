<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {

        Order::create([
            'user_id' => 1,
            'total_amount' => 200.00,
            'order_status' => 'Hazırlık',
        ]);

        Order::create([
            'user_id' => 1,
            'total_amount' => 50.00,
            'order_status' => 'Kargoya Verildi',
        ]);


    }
}
