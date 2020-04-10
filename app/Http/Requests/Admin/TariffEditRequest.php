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

    public function messages()
    {
        return [
            'name.required' => 'name_required',
            'name.string' => 'name_string',
            'name.min' => 'name_min',
            'short_name.required' => 'short_name_required',
            'short_name.string' => 'short_name_string',
            'short_name.min' => 'short_name_min',
            'short_name.max' => 'short_name_max',
            'price.required' => 'price_required',
            'price.numeric' => 'price_numeric',
            'currency.required' => 'currency_required',
            'currency.string' => 'currency_string',
            'currency.size' => 'currency_size',
            'period.required' => 'period_required',
            'prolongable.boolean' => 'prolongable_boolean',
        ];
    }
}
