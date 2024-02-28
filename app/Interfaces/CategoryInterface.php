<?php

namespace App\Interfaces;

use App\Http\Requests\Categories\AddCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use Illuminate\Support\Collection;

interface CategoryInterface
{
    public function getAllCategories(): Collection;

    public function deleteCategory($id);

    public function editCategory(EditCategoryRequest $request, $id);

    public function addCategory(AddCategoryRequest $request);
}
