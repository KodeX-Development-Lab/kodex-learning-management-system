<?php

namespace App\Modules\Languages\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
        $name_rule = 'required|string|unique:languages,name';
        $code_rule = 'required|string|unique:languages,code';

        if ($this->route()->getName() == 'api.languages.update') {
            $name_rule = 'required|string|unique:languages,name,' . $this->language . ',id';
            $code_rule = 'required|string|unique:languages,code,' . $this->language . ',id';
        }

        return [
            'name' => $name_rule,
            'code' => $code_rule,
        ];
    }
}
