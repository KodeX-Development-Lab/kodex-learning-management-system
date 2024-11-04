<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizApiRequest extends FormRequest
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
            'section_id'      => 'nullable|exists:sections,id',
            'title'           => 'required|string|max:255',
            'question'        => 'required|string',
            'provided_answer' => 'nullable|string|max:255',
            'answer'          => 'nullable|string|max:255',
        ];

    }
}
