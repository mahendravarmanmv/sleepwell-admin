<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'unique:products,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'key_features' => [
                'nullable',
                'array',
            ],

            'key_features.*' => [
                'nullable',
                'string',
                'max:500',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'emi_starting_price' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'badge_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'badge_color' => [
                'nullable',
                'string',
                'max:50',
            ],

            'image_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}