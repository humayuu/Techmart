<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminPasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ];
    }
}
