<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore(auth('admin')->id()),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }
}
