<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Questions_filter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestions_filterRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return Questions_filter::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cod_fam' => 'required|string|max:191'
        ];
    }
}
