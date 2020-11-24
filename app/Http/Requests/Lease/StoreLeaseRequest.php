<?php

namespace App\Http\Requests\Lease;

use App\Rules\Common\DateFreezer;
use App\Rules\Common\RuleService;
use App\Rules\Lease\CostCenterSplitRule;
use App\Rules\Lease\ExtensionCheck;
use App\Rules\Lease\LeaseExtensionChangeDate;
use App\Rules\Lease\TerminateLeaseNoExtension;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;

class StoreLeaseRequest extends \App\Http\Requests\Request
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
            'effective_date' => ['bail', 'required', 'date_format:Y-m-d', 'date', new DateFreezer()],
            'maturity_date' => ['required', 'date', 'date_format:Y-m-d', 'after:effective_date'],
            'contractual_end_date' => ['nullable', 'date', 'date_format:Y-m-d', 'after:effective_date'],
            'first_payment_date' => ['required', 'date', 'date_format:Y-m-d', 'after:effective_date'],
            'text' => 'max:1700',
            'entity_id' => 'required',
            'counterparty_id' => 'required |different:entity_id',
            'lease_flow_per_year' => 'numeric | in:' . implode(',', [1, 2, 3, 4, 6, 12]),
            'payment_day' => 'required',
            'portfolio_id' => 'required',
            'lease_type_id' => 'required',
            'lease_rate' => 'required|numeric|min:0',
            'lease_amount' => array_merge(['required', 'numeric'], RuleService ::maxMinNum()),
            'lease_service_cost' => array_merge(['required', 'numeric'], RuleService ::maxMinNum()),
            'document_file' => $this -> fileValidation(),
            'cost_center_split_id' => ['nullable', 'array'],
            'tax' => ['nullable', 'string'],
            'rou_asset_number' => ['nullable', 'string'],
            'internal_order' => ['nullable', 'string'],
            'percentage' => [new CostCenterSplitRule, 'array', 'required_if:cost_center_split,1'],
            'notice_period_in_months' => 'integer|nullable',
            'number_of_employees' => 'integer|nullable',
            'number_of_workstations' => 'integer|nullable',
            'number_of_parking_spaces' => 'integer|nullable',
        ];

        if($this -> method() == 'PATCH') {
            $rule['effective_date'] = ['bail', 'required', 'date_format:Y-m-d', 'date'];
        }

        $leaseId = Request ::segment(2);
        if(is_numeric($leaseId)) {
            $rule['lease_rate'] = 'nullable';
            $rule['lease_amount'] = 'nullable';
            $rule['lease_service_cost'] = 'nullable';
            $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);
            $leaseFlows = LeaseFlowService ::leaseFlows($lease);
        } else {
            $rule['currency_id'] = 'required';
        }
        if($this -> input('lease_extension_type')) {
            $lastExtension = LeaseExtensionService ::lastExtension($lease);
            $firstFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($lease, $lastExtension -> id);
            if($firstFlow instanceof LeaseFlow) {
                if($lease -> currency_id != $lease -> entity -> currency_id) {
                    $rule['date_of_change'] = $this -> dateOfChangeDifferentCurrency($firstFlow, $lease);
                } else {
                    $rule['date_of_change'] = array('bail', 'required', 'date', 'after:' . $firstFlow -> end_date, new TerminateLeaseNoExtension($lease), new LeaseExtensionChangeDate($lease), new DateFreezer());
                }
            } else {
                $rule['date_of_change'] = array('bail', 'required', 'date', new TerminateLeaseNoExtension($lease), new LeaseExtensionChangeDate($lease), new DateFreezer());
            }

            $rule['extension_start_date'] = 'required|date|after_or_equal:date_of_change';
            switch(request() -> get('lease_extension_type')){
                case "Decrease In Term":
                    $rule['extension_end_date'] = ['required', 'date', 'before_or_equal:maturity_date', 'after_or_equal:extension_start_date', new ExtensionCheck($lease)];
                    break;
                case "Decrease In Scope":
                    $rule['decrease_in_scope_rate'] = ['required', 'min:1', new ExtensionCheck($lease)];
                    break;
                case "Increase In Scope":
                    $rule['extension_end_date'] = ['required', 'date', 'after_or_equal:extension_start_date', new ExtensionCheck($lease)];
                    break;
                case "Terminate Lease":
                    $rule['extension_start_date'] = ['nullable', new DateFreezer()];
                    break;
            }
        }


        return $rule;
    }

    public function messages()
    {
        return [
            'effective_date.required' => trans('master.The commencement date is required'),
            'maturity_date.required' => trans('master.The end date is required'),
            'extension_end_date.before_or_equal' => trans('master.The decrease in term date cannot be after lease end date'),
            'extension_start_date.after_or_equal' => trans('master.The change start date must be after date of change'),
            'document_file.max' => trans('master.The document file may not be greater than 5 MB.'),
            'first_payment_date.after' => trans('master.The first payment date must be date after commencement date'),
            'date_of_change.before' => trans('master.Since the currency of entity and lease is different, the date of change cannot be for future'),
            'percentage.required_if' => trans('master.Please add cost center with percentage if cost center split is on'),
            'lease_flow_per_year.numeric' => trans('master.The payment per year field must be a number'),
            'lease_flow_per_year.in_array' => trans('master.The payment per year field must be 1, 2, 3, 4, 6 or 12'),
            'lease_rate.min' => trans('master.The interest rate must be positive'),
        ];
    }

    public function dateOfChangeDifferentCurrency($firstFlow, $lease)
    {
        return array('bail', 'required', 'date', 'before:' . today() -> toDateString(), 'after:' . $firstFlow -> end_date, new TerminateLeaseNoExtension($lease), new LeaseExtensionChangeDate($lease), new DateFreezer());
    }

    public function costCenterSplit($lease)
    {
        if($lease -> cost_center_split) {
            return array_sum($this -> input('percentage')) == 100;
        }
    }
}
