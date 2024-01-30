<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    protected  $categoryRepository;

    public function __construct(CategoryRepository  $categoryRepository)
    {
        $this->categoryRepository  = $categoryRepository;
    }

    public function getAllProducts(): JsonResponse
    {
        $categories= $this->categoryRepository->getAllCategories();
        return response()->json($categories);
    }
}
