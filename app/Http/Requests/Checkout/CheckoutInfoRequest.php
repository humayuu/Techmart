<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:20'],
            'shipping_method' => ['required', 'string'],
            'coupon_code' => ['nullable', 'string', 'max:100'],
        ];
    }
}
