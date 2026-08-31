<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'unique:categories,slug',
            ],

            'icon_class' => [
                'nullable',
                'string',
                'max:255',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'icon_class' => 'icon class',
            'parent_id' => 'parent category',
        ];
    }
}