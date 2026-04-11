<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'slider' => ['required', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }
}
