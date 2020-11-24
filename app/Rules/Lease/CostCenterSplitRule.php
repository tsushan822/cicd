<?php

namespace App\Rules\Lease;

use Illuminate\Contracts\Validation\Rule;

class CostCenterSplitRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(request()->input('cost_center_split') == 1 && !is_null($value) && is_array($value))
        {
            if(number_format((double)array_sum($value), 2, '.', '')==100){
                return true;
            }
            else{
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('master.The sum of percentage in cost center split must be 100.');
    }
}
