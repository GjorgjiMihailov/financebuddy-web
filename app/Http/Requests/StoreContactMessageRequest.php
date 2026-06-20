<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:50',
            'service_interest' => 'nullable|string|max:255',
            'message'          => 'required|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Внесете го вашето ime и презиме.',
            'email.required'   => 'Внесете е-маил адреса.',
            'email.email'      => 'Внесете валидна е-маил адреса.',
            'message.required' => 'Внесете порака.',
            'message.max'      => 'Пораката не смее да надмине 5000 знаци.',
        ];
    }
}
