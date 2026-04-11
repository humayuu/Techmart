<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brand = $this->route('brand');

        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('brands', 'brand_name')->ignore($brand->id),
            ],
            'description' => ['required'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }
}
