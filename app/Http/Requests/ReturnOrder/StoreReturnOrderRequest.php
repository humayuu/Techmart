<?php

namespace App\Http\Requests\ReturnOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'reason' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }
}
