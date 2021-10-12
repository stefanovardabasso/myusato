<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Mymachine;
use Illuminate\Foundation\Http\FormRequest;

class StoreMymachineRequest extends FormRequest
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
        return Mymachine::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_offert' => 'required|string|max:191'
        ];
    }
}
