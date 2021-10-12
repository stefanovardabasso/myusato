<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Contactform;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactformRequest extends FormRequest
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
        return Contactform::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_email' => 'required|string|max:191'
        ];
    }
}
