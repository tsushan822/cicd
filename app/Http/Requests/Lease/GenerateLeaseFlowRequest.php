<?php

namespace App\Http\Requests\Lease;

use App\Rules\Common\DateFreezer;
use App\Rules\Common\RuleService;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Model\Lease;
use Illuminate\Foundation\Http\FormRequest;

class GenerateLeaseFlowRequest extends FormRequest
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
        $leaseId = $this -> input('lease');
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);
        $startDate = $lease -> effective_date;
        return [
            'lease_payment_amount' => array_merge(['required', 'numeric'], RuleService ::maxMinNum()),
            'negotiate_price_increase_percent' => 'nullable|numeric|max:99.999999',
            'negotiate_price_increase_amount' => array_merge(['nullable', 'numeric'], RuleService ::maxMinNum()),
            'end_date' => ['required ', 'date', ' after:' . $startDate, new DateFreezer()],
            'payment_date' => ['required ', ' date', ' after:' . $startDate, new DateFreezer()],
        ];
    }

    public function messages()
    {
        return [
            'payment_date.required' => 'First payment date is required.'
        ];
    }
}
