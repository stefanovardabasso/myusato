<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Suprlift;
use Illuminate\Foundation\Http\FormRequest;

class StoreSuprliftRequest extends FormRequest
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
        return Suprlift::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offert_id' => 'required|string|max:191'
        ];
    }
}
