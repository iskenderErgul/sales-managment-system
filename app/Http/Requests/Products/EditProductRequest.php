<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ];
    }
}
