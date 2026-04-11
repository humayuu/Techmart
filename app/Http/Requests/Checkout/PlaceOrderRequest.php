<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
            'stripe_token' => ['required_if:payment_method,stripe', 'nullable', 'string'],
            'note' => ['nullable', 'string'],
        ];
    }
}
