<?php

namespace App\Http\Requests\Lease;

use App\Rules\Common\DateFreezer;
use App\Rules\Common\RuleService;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeaseFlowRequest extends FormRequest
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
            'payment_date' => [new DateFreezer()],
            'fixed_payment' => array_merge(['nullable', 'numeric'], RuleService ::maxMinNum()),
            'fees' => array_merge(['nullable', 'numeric'], RuleService ::maxMinNum()),
            'variations' => array_merge(['nullable', 'numeric'], RuleService ::maxMinNum()),
        ];
        return $rule;
    }
}
