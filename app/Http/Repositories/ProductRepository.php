<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllProducts(){
        return Product::all();
    }

    public function getProduct($id) {
        return  Product::where('id',$id)->first();


    }
}
