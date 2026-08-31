<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'dealer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_verified' => [
                'required',
                'boolean',
            ],
        ];
    }
}