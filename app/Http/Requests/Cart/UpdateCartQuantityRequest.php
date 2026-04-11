<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartQuantityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
