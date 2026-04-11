<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:brands,brand_name'],
            'description' => ['required'],
            'logo' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }
}
