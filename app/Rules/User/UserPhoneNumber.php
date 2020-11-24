<?php

namespace App\Rules\User;

use App\Zen\User\Model\User;
use Illuminate\Contracts\Validation\Rule;

class UserPhoneNumber implements Rule
{
    protected $id;

    /**
     * Create a new rule instance.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this -> id = $id;
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
        $id = $this -> id;

        $query = User :: where('phone_number', request('phone_number'));
        if($id) {
            $query = $query -> where('id', '!=', $id);
        }
        $number = $query -> count();

        return $number < 1 ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('master.The phone number should be unique.');
    }
}
