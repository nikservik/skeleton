<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TariffEditRequest extends FormRequest
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
            'short_name' => 'required|string|min:3|max:15', 
            'name' => 'required|string|min:3', 
            'price' => 'required|numeric', 
            'currency' => 'required|string|size:3', 
            'period' => 'required', 
            'prolongable' => 'boolean'
        ];
    }
}
