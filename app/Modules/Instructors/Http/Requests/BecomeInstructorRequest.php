<?php

namespace App\Modules\Instructors\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BecomeInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'professional_field_id'     => 'required|exists:professional_fields,id',
            'work_experience_years'     => 'nullable|numeric|min:0',
            'teaching_experience_years' => 'nullable|numeric|min:0',
            'certificates'              => "nullable|array",
            'certificates.*.title'      => 'required|string',
            'certificates.*.attachment' => 'nullable|string',
        ];
    }
}
