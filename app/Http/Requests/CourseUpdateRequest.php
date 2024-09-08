<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // $courseId = $this->route('course');

        return [
            'title' => 'sometimes|required|string|max:255',
            // 'slug' => 'sometimes|required|string|max:255|unique:courses,slug,' . $courseId,
            'user_id' => 'sometimes|required|uuid|exists:users,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',
            'language_ids' => 'nullable|array',
            'language_ids.*' => 'integer|exists:languages,id',
            'what_will_learn' => 'nullable|string',
            'requirement' => 'nullable|string',
            'description' => 'nullable|string',
            'for_whom' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'preview' => 'nullable|boolean',
            'last_updated_at' => 'sometimes|required|date',
            'level' => 'sometimes|required|string|max:50',
            'is_published' => 'nullable|boolean',
            'useful_links' => 'nullable|array',
            'useful_links.*' => 'url',
            'total_time' => 'sometimes|required|integer',
        ];

    }
}
