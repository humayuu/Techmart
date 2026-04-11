<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
        ];
    }
}
