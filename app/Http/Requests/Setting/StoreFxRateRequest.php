<?php

namespace App\Http\Requests\Setting;

use App\Rules\Common\RuleService;
use App\Rules\FxRateUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFxRateRequest extends FormRequest
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
        return [
            'ccy_base_id' => 'required|numeric',
            'ccy_cross_id' => 'required|numeric|different:ccy_base_id',
            'rate_bid' => array_merge(['required', 'numeric'], RuleService ::maxMinNum()),
            'date' => ['bail','required', 'date', new FxRateUniqueRule($this -> input('ccy_base_id'), $this -> input('ccy_cross_id'), $this -> input('date'))],
        ];
    }
}
