<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 10/09/2018
 * Time: 10.13
 */

namespace App\Rules\Report;


use Illuminate\Contracts\Validation\Rule;

class RequireACheckBox implements Rule
{

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if(count($value))
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.Please check at least one check box.');
    }
}