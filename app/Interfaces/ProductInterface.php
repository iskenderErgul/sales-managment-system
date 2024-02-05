<?php

namespace App\Interfaces;

use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\BulkDeleteProductRequest;
use App\Http\Requests\Products\DeleteProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Http\Requests\Products\GetProductRequest;
use Illuminate\Http\Request;

interface ProductInterface
{
    public function getAllProducts();

    public function getProduct(GetProductRequest $request ,$id);

    public function deleteProduct(DeleteProductRequest $request ,$id);

    public function bulkDelete(BulkDeleteProductRequest $request);

    public function addProduct(AddProductRequest $request);

    public function editProduct(EditProductRequest $request, $id);
}
