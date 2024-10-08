<?php

namespace App\Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rule()
    {
        $this->merge(['course_id' => $this->route('course_id')]);

        return [
            'course_id' => 'required|exists:courses,id',
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string|max:1000',
            'order'     => 'nullable|numeric|min:0',
        ];
    }
}
