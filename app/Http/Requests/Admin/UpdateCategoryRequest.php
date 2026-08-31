<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $category = $this->route('category');

        $categoryId = $category instanceof \App\Models\Category
            ? $category->id
            : $category;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($categoryId),
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
                'not_in:' . $categoryId,
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