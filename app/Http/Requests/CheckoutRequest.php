<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:50', 'regex:/^[\d\s\+\-\(\)]+$/'],
            'delivery_address' => 'required|string|max:500',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Телефон может содержать только цифры, пробелы, +, -, скобки.',
        ];
    }
}
