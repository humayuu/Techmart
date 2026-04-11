<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'subject' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}
