<?php

namespace App\Http\Requests\Product;

use App\Rules\DiscountLessThanSellingPrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');

        return [
            'brand' => ['required'],
            'category' => ['required'],
            'product_name' => [
                'required',
                'min:5',
                'max:100',
                Rule::unique('products', 'product_name')->ignore($id),
            ],
            'product_code' => ['required'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['required', 'numeric', 'min:0', new DiscountLessThanSellingPrice],
            'quantity' => ['required', 'integer', 'min:0'],
            'weight' => ['required'],
            'tags' => ['required'],
            'short_description' => ['required'],
            'long_description' => ['required'],
            'thumbnail' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2048'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2048'],
            'other_info' => ['required'],
        ];
    }
}
