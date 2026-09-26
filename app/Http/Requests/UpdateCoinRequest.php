<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'year' => 'required|integer|min:1000|max:2100',
            'country' => 'required|string|max:100',
            'condition' => 'required|string|max:50',
            'status' => 'required|in:available,reserved,sold',
            'image_url' => 'nullable|url|max:500',
        ];
    }
}
