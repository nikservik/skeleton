<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileEmailSaveRequest extends FormRequest
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
            'email' => [
                'required',
                'email:strict,dns',
                Rule::unique('users')->ignore(Auth::id()),
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email.required',
            'email.email' => 'email.email',
            'email.unique' => 'email.unique',
        ];
    }
}
