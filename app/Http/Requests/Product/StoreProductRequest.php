<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => ['required'],
            'category' => ['required'],
            'product_name' => ['required', 'unique:products,product_name', 'min:5', 'max:100'],
            'product_code' => ['required'],
            'selling_price' => ['required'],
            'discount_price' => ['required'],
            'quantity' => ['required'],
            'weight' => ['required'],
            'tags' => ['required'],
            'short_description' => ['required'],
            'long_description' => ['required'],
            'thumbnail' => ['required', 'mimes:jpeg,jpg,png', 'max:2048'],
            'images.*' => ['required', 'mimes:jpeg,jpg,png', 'max:2048'],
            'other_info' => ['required'],
        ];
    }
}
