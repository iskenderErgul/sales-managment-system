<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository
{
    public function getAllProducts(){
        return Product::all();
    }

    public function getProduct($id) {
        return  Product::where('id',$id)->first();


    }
    public function deleteProduct($id)
    {
        return Product::where('id',$id)->delete();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        Product::whereIn('id', $ids)->delete();
    }
}

