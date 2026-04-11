<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $coupon = $this->route('coupon');

        return [
            'coupon_name' => [
                'required',
                'string',
                Rule::unique('coupons', 'coupon_name')->ignore($coupon->id),
            ],
            'coupon_discount' => ['required', 'numeric', 'min:0', 'max:100'],
            'valid_until' => ['required', 'date'],
        ];
    }
}
