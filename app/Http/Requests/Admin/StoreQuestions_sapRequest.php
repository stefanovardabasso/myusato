<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Questions_sap;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestions_sapRequest extends FormRequest
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
        return Questions_sap::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code_q' => 'required|string|max:191'
        ];
    }
}
