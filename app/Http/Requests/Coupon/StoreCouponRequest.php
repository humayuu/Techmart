<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'coupon_name' => ['required', 'string', 'unique:coupons,coupon_name'],
            'coupon_discount' => ['required', 'numeric', 'min:0', 'max:100'],
            'valid_until' => ['required', 'date'],
        ];
    }
}
