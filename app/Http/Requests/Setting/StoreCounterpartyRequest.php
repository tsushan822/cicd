<?php

namespace App\Http\Requests\Setting;

use App\Http\Requests\Request;
use App\Rules\LeiValidation;
use App\Rules\UniqueCheckEncrypted;
use App\Zen\Setting\Model\Counterparty;

class StoreCounterpartyRequest extends Request
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
        if($this -> getMethod() == 'PATCH') {
            $id = $this -> counterparty -> getAttribute('id');
        } else {
            $id = null;
        }
        $rules = [
            'currency_id' => 'required',
            'is_entity' => $this -> isEntity(),
            'is_counterparty' => $this -> isCounterparty(),
            'country_id' => 'required|numeric|min:1',
            'lease_rate' => 'required|numeric|min:0',
        ];
        if($id) {
            $rules['short_name'] = ['required', new UniqueCheckEncrypted(new Counterparty, $id)];
            $rules['long_name'] = ['required', new UniqueCheckEncrypted(new Counterparty, $id)];
            $rules['alias_360t'] = ['nullable', new UniqueCheckEncrypted(new Counterparty, $id)];
            $rules['alias_fxall'] = ['nullable', new UniqueCheckEncrypted(new Counterparty, $id)];
        } else {
            $rules['short_name'] = ['required', new UniqueCheckEncrypted(new Counterparty)];
            $rules['long_name'] = ['required', new UniqueCheckEncrypted(new Counterparty)];
            $rules['alias_360t'] = ['nullable', new UniqueCheckEncrypted(new Counterparty)];
            $rules['alias_fxall'] = ['nullable', new UniqueCheckEncrypted(new Counterparty)];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'long_name.required' => 'The Name of the counterparty field is required.',
            'is_entity.different' => 'The entity can only be internal.',
            'is_counterparty.different' => 'The company should be either entity or counterparty or both.',
            'lease_rate.min' => trans('master.The interest rate must be positive'),
            'lease_rate.required' => trans('master.The interest rate is required'),
        ];
    }

    public function isEntity()
    {
        if($this -> input('is_entity') == 1)
            return 'different:is_external';

        return '';

    }

    public function isCounterparty()
    {
        if($this -> input('is_entity') == 1)
            return '';

        return 'different:is_entity';

    }
}

