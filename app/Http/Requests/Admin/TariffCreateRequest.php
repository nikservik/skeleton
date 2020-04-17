<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TariffCreateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name.*' => 'required|string|min:3',
            'slug' => 'required|string|min:3|max:15', 
            'price' => 'required|numeric', 
            'currency' => 'required|string|size:3', 
            'period' => 'required', 
            'prolongable' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => 'name_required',
            'name.*.string' => 'name_string',
            'name.*.min' => 'name_min',
            'slug.required' => 'slug_required',
            'slug.string' => 'slug_string',
            'slug.min' => 'slug_min',
            'slug.max' => 'slug_max',
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
