<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\BulkDeleteProductRequest;
use App\Http\Requests\Products\DeleteProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Http\Requests\Products\GetProductRequest;
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

    public function getProduct(GetProductRequest $request , $id): JsonResponse
    {
        $product = $this->productRepository->getProduct($request ,$id);
        return response()->json($product);
    }

    public function deleteProduct(DeleteProductRequest $request ,$id): JsonResponse
    {
        dd($request->all());
        $product = $this->productRepository->deleteProduct($request ,$id);
        return response()->json($product);
    }
    public  function bulkDelete(BulkDeleteProductRequest $request): JsonResponse
    {
        $products = $this->productRepository->bulkDelete($request);
        return response()->json($products);
    }

    public function addProduct(AddProductRequest $request): JsonResponse
    {
        $product = $this->productRepository->addProduct($request);
        return response()->json($product);
    }
    public  function  editProduct(EditProductRequest $request,$id): JsonResponse
    {
        $product = $this->productRepository->editProduct($request,$id);
        return response()->json($product);
    }


}
