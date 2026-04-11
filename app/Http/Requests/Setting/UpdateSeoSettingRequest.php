<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeoSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta_title' => ['required', 'string', 'max:60'],
            'meta_author' => ['required', 'string', 'max:100'],
            'meta_keyword' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:160'],
            'google_analytics' => ['required', 'string', 'max:50'],
        ];
    }
}
