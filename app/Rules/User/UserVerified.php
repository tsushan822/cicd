<?php

namespace App\Rules\User;

use App\Zen\User\Model\User;
use Illuminate\Contracts\Validation\Rule;

class UserVerified implements Rule
{
    public $message;

    /**
     * Determine if the validation rule passes.
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User ::where($attribute, $value) -> first();
        if($user -> verified) {
            if($user -> active_status) {
                return true;
            }
            if($user->wrong_password_blocked_at){
                $this -> message = trans('master.Sorry! The user is locked due to wrong password attempts. Contact administrator.');
            } else {
                $this -> message = trans('master.Sorry! This user is not active.');
            }
            return false;
        }

        $this -> message = trans('master.Sorry! This user is not verified.');

        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return $this -> message;
    }
}
