<?php

namespace App\Http\Repositories;

use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\bulkDeleteProductRequest;
use App\Http\Requests\Products\DeleteProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Http\Requests\Products\GetProductRequest;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements  ProductInterface
{
    public function getAllProducts(){
        return Product::all();
    }

    public function getProduct(GetProductRequest $request ,$id) {
        return  Product::where('id',$id)->first();

    }
    public function deleteProduct(DeleteProductRequest $request ,$id)
    {
        return Product::where('id',$id)->delete();
    }

    public function bulkDelete(BulkDeleteProductRequest $request)
    {
        $ids = $request->input('ids', []);
        Product::whereIn('id', $ids)->delete();
    }

    public function addProduct(AddProductRequest $request)
    {
        return Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => null,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity
        ]);
    }

    public function editProduct(EditProductRequest $request,$id)
    {
       return Product::where('id',$id)->update([
           'name' => $request->name,
           'description' => $request->description,
           'category_id' => $request->category_id,
           'image' => $request->image,
           'price' => $request->price,
           'stock_quantity' => $request->stock_quantity,
       ]);

    }
}



