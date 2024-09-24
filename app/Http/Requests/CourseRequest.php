<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        return [
            'title'              => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'language_id'        => 'required|exists:languages,id',
            'level'              => 'required|in:Beginner,Intermediate,Advanced',
            'topics'             => 'nullable|array',
            'topics.*'           => 'required|exists:topics,id',
            'description'        => 'nullable|string',
            'what_will_learn'    => 'nullable|string',
            'requirements'       => 'nullable|string',
            'details'            => 'nullable|string',
            'for_whom'           => 'nullable|string',
            'thumbnail'          => 'required|image',
            'preview_video_url'  => 'nullable|url',
            'is_published'       => 'nullable|boolean',
            'useful_links'       => 'nullable|array',
            'useful_links.*'     => 'url',
            'attachments'        => 'nullable|array',
            'attachments.*'      => 'file',
            'total_time_minutes' => 'required|integer|min:0',
        ];
    }
}
