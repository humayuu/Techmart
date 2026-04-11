<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserStoreRequest extends FormRequest
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,normal_user'],
            'status' => ['required', 'in:active,inactive'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'access' => ['required'],
        ];
    }
}
