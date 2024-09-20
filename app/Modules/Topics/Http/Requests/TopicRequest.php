<?php

namespace App\Modules\Topics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
        $name_rule = 'required|string|unique:topics,name';

        if ($this->route()->getName() == 'api.topics.update') {
            $name_rule = 'required|string|unique:topics,name,' . $this->topic . ',id';
        }

        return [
            'name'        => $name_rule,
            'description' => 'nullable|string',
        ];
    }
}
