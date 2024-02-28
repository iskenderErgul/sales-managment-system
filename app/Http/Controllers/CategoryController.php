<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\Categories\AddCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository  $categoryRepository)
    {
        $this->categoryRepository  = $categoryRepository;
    }

    public function getAllProducts(): JsonResponse
    {
        $categories= $this->categoryRepository->getAllCategories();
        return response()->json($categories);
    }

    public function deleteCategory($id): JsonResponse
    {

        $category=$this->categoryRepository->deleteCategory($id);
        return response()->json($category);
    }

    public function editCategory(EditCategoryRequest $request, $id):JsonResponse
    {
        $category=$this->categoryRepository->editCategory($request,$id);
        return response()->json($category);
    }
    public function addCategory(AddCategoryRequest $request):JsonResponse
    {
        $category=$this->categoryRepository->addCategory($request);
        return response()->json($category);
    }
}
