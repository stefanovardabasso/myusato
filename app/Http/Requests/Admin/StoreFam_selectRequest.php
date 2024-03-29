<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Fam_select;
use Illuminate\Foundation\Http\FormRequest;

class StoreFam_selectRequest extends FormRequest
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
        return Fam_select::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_button' => 'required|string|max:191'
        ];
    }
}
