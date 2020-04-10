<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
            'role' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value >= Auth::user()->role) {
                        $fail('role.unallowed');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name_required',
            'name.string' => 'name_string',
            'name.min' => 'name_min',
            'email.required' => 'email_required',
            'email.email' => 'email_email',
            'email.unique' => 'email_unique',
            'password.required' => 'password_required',
            'password.min' => 'password_min',
            'password.confirmed' => 'password_confirmed',
            'role.required' => 'role_required',
            'role.unallowed' => 'role_unallowed',
        ];
    }
}
