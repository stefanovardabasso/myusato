<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Offert;
use Illuminate\Foundation\Http\FormRequest;

class StoreOffertRequest extends FormRequest
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
        return Offert::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:191',
            'createdby' => 'required|string|max:191',
            'type_off' => 'required',
            'id_product'=> 'required|string|max:191',
            'descripit' => 'required|string',
            'descripen' => 'required|string',
            'price_cal_uf' => 'required|string|max:191',
            'price_min_uf' => 'required|string|max:191',
            'date_fin_of_uf'=> 'required|string|max:191',
            'gp_uf'=> 'required|string|max:191',
            'status_fin_uf'=> 'required|string|max:191',
            'price_uf'=> 'required|string|max:191',
            'price_cal_co' => 'required|string|max:191',
            'price_min_co' => 'required|string|max:191',
            'date_fin_of_co'=> 'required|string|max:191',
            'gp_co'=> 'required|string|max:191',
            'status_fin_co'=> 'required|string|max:191',
            'price_co'=> 'required|string|max:191',





        ];
    }
}
