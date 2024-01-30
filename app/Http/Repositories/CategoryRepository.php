<?php

namespace App\Http\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }


}
