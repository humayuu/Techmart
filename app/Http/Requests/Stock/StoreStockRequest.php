<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'stock' => ['required'],
        ];
    }
}
