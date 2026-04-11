<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'province_id' => ['required'],
            'name' => ['required', 'string', 'max:30'],
            'is_active' => ['required'],
        ];
    }
}
