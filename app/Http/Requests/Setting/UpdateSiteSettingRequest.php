<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'mimes:jpg,png,jpeg', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'x' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
        ];
    }
}
