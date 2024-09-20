<?php

namespace App\Modules\CourseUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rule()
    {
        return [
            'course_id'    => 'required|exists:courses,id',
            'user_id'      => 'required|exists:users,id',
            'enrolled_at'  => 'nullable|date',
            'completed_at' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
        ];
    }
}
