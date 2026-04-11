<?php

namespace App\Http\Requests\Province;

use Illuminate\Foundation\Http\FormRequest;

class StoreProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
        ];
    }
}
