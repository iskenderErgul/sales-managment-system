<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrders(): Collection|array
    {
        return Order::with('orderItems')->get();
    }

}
