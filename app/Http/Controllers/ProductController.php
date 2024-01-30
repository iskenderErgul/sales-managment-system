<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected  $productRepository;

    public function __construct(ProductRepository  $productRepository)
    {
        $this->productRepository  = $productRepository;
    }

    public function getAllProducts(): JsonResponse
    {
       $products= $this->productRepository->getAllProducts();
        return response()->json($products);
    }

    public function getProduct(Request $request , $id){
        $product = $this->productRepository->getProduct($id);
        return response()->json($product);
    }

    public function deleteProduct($id){
        $product = $this->productRepository->deleteProduct($id);
        return response()->json($product);
    }
    public  function bulkDelete(Request $request){
        $products = $this->productRepository->bulkDelete($request);
        return response()->json($products);
    }
}
