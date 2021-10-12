<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Notification;
use App\Rules\CKEditorNotEmpty;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateNotificationRequest extends FormRequest
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
        return Notification::getAttrsTrans();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'text' => new CKEditorNotEmpty(),
            'roles.*' => 'exists:roles,id',
            'roles' => 'required',
            'start' => [
                'required',
                function($attribute, $value, $fail) {
                    if(Carbon::createFromFormat('d/m/Y H:i', $value) == false) {
                        return $fail(__(':attribute is invalid date.'));
                    }
                    return true;
                }
            ],
            'end' => [
                'required',
                function($attribute, $value, $fail) {
                    if(Carbon::createFromFormat('d/m/Y H:i', $value) == false) {
                        return $fail(__(':attribute is invalid date.'));
                    }
                    return true;
                },
                function($attribute, $value, $fail) {
                    $endDate = Carbon::createFromFormat('d/m/Y H:i', $value);
                    $startDate = Carbon::createFromFormat('d/m/Y H:i', request('start'));
                    if(!$endDate->gt($startDate)) {
                        return $fail(__(':attribute end should be after start'));
                    }
                    return true;
                }
            ],
            'attachments.*' => 'nullable|file'
        ];
    }
}
