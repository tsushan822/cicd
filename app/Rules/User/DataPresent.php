<?php

namespace App\Rules\User;

use App\Zen\User\Model\User;
use Illuminate\Contracts\Validation\Rule;

class DataPresent implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User ::where($attribute, $value) -> first();

        if($user instanceof User)
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry! user with this :attribute is not present in our system.';
    }
}
