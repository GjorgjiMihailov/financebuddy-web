<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'slug'             => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($this->route('post'))],
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'category_id'      => 'nullable|exists:categories,id',
            'new_category'     => 'nullable|string|max:100',
            'author_name'      => 'nullable|string|max:100',
            'status'           => 'required|in:draft,published',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'featured_image'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Насловот е задолжителен.',
            'slug.required'        => 'Slug-от е задолжителен.',
            'slug.unique'          => 'Постои пост со овој slug. Сменете го.',
            'content.required'     => 'Содржината е задолжителна.',
            'featured_image.max'   => 'Сликата не смее да биде поголема од 5MB.',
            'featured_image.mimes' => 'Дозволени формати: JPG, PNG, WebP.',
        ];
    }
}
