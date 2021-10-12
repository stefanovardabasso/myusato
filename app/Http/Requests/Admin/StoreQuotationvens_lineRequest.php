<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Quotationvens_line;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationvens_lineRequest extends FormRequest
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
        return Quotationvens_line::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_quotationven' => 'required|string|max:191'
        ];
    }
}
