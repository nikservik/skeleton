<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordSaveRequest extends FormRequest
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
            'password'  => 'required|min:8|confirmed',
            'old_password'  => 'required|password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'old_password.required',
            'old_password.password' => 'old_password.password',
            'password.required' => 'password.required',
            'password.min' => 'password.min',
            'password.confirmed' => 'password.confirmed',
        ];
    }
}
