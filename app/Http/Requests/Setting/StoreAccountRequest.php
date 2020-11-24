<?php

namespace App\Http\Requests\Setting;


use App\Http\Requests\Request;

class StoreAccountRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rule = [
            'counterparty_id' => 'required',
            'account_name' => 'required|max:255',
            'client_account_number' => 'required|integer',
            'client_account_name' => 'required|max:255',
            'country_id' => 'required',
            'currency_id' => 'required',
            'IBAN' => 'required|max:255|alpha_num',
            'bank' => 'required|max:255',
            'BIC' => 'required|max:255',
        ];
        if(is_numeric(Request ::segment(2)))
            $rule['currency_id'] = 'nullable';

        return $rule;
    }

    public function messages()
    {
        return [
            'IBAN.required' => 'The IBAN field is required.',
            'BIC.required' => 'The BIC field is required.',
            'bank.required' => 'The Bank field is required.',
            'counterparty_id.required' => 'Please select account owner.',
            'heading_three_id.required' => 'The heading three field is required.',
        ];
    }

}
