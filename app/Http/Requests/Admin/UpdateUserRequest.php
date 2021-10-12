<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\User;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserRequest extends FormRequest
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
        $attributes = User::getAttrsTrans();
        $attributes['password_confirmation'] = __('password_confirmation-form-label');
        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $baseRules = [
            'email' => 'required|string|email|max:191|unique:users,email,' . $this->user->id,
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'password' => 'nullable|string|min:6|confirmed|',
            'roles' => 'required',
            'roles.*' => 'required|exists:roles,id',
            'locale' => 'nullable|in:' . implode(',', array_keys(config('main.available_languages'))),
            'active' => 'required|boolean',
        ];

        $sensitiveData = [];

        if(Auth::user()->can('change_active_status', User::class)) {
            $sensitiveData['active'] = 'required|boolean';
        }

        if(Auth::user()->can('assign_roles', User::class)) {
            $sensitiveData ['roles']= 'required';
            $sensitiveData ['roles.*']= 'required|exists:roles,id';
        }

        return array_merge($baseRules, $sensitiveData);
    }
}
