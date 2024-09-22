<?php

namespace App\Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'course_id'   => 'required|exists:courses,id',
            'section_id'  => 'required|exists:sections,id',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable',
            'attachment'  => 'nullable',
            'order'       => 'nullable|nemuric|integer|min:0',
        ];
    }
}
