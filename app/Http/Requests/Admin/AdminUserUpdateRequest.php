<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:admin,normal_user'],
            'access' => ['required'],
        ];
    }
}
