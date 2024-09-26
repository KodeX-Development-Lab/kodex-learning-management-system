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
        $this->merge(['course_id' => $this->route('course_id')]);
        $this->merge(['section_id' => $this->route('section_id')]);
        
        return [
            'course_id'   => 'required|exists:courses,id',
            'section_id'  => 'required|exists:sections,id',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable|url',
            'attachment'  => 'nullable|file',
            'order'       => 'nullable|numeric|integer|min:0',
        ];
    }
}
