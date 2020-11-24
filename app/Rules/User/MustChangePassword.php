<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/10/2018
 * Time: 11.49
 */

namespace App\Rules\User;

use App\Zen\User\Model\User;
use Illuminate\Contracts\Validation\Rule;

class MustChangePassword implements Rule
{
    /**
     * @var
     */
    private $email;

    /**
     * Create a new rule instance.
     * @param $email
     */
    public function __construct($email)
    {

        $this -> email = $email;
    }

    /**
     * Determine if the validation rule passes.
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User ::where('email', $this -> email) -> first();
        if($user -> must_change_password)
            return true;
        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'Sorry! This user needs to reset password.';
    }
}

