<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyRequest extends FormRequest
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
            'iso_4217_code' => 'required',
            'iso_number' => 'required',
            'iso_3166_code' => 'required',
            'currency_name' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'iso_4217_code.required' => 'The code field is required',
            'iso_number.required' => 'The Numeric code field is required',
        ];
    }
}
