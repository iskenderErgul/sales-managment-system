<?php

namespace App\Http\Repositories;

use App\Http\Requests\Categories\AddCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryInterface
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function deleteCategory($id)
    {
        return Category::findOrFail($id)->delete();
    }

    public function editCategory(EditCategoryRequest $request, $id)
    {
        return Category::where('id',$id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
    }

    public function addCategory(AddCategoryRequest $request)
    {
        return Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

    }


}
