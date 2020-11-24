<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/10/2018
 * Time: 11.49
 */

namespace App\Rules\User;

use App\Zen\Setting\Model\AdminSetting;
use App\Zen\User\Model\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class PasswordExpiration implements Rule
{
    /**
     * @var
     */
    private $email;
    private $days;
    private $enableChangePassword;

    /**
     * Create a new rule instance.
     * @param $email
     */
    public function __construct($email)
    {

        $this -> email = $email;
        $this -> days = config('password_validation.password_change_days');
        $this -> enableChangePassword = config('password_validation.enable_change_password');

        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting && $adminSetting -> password_change_days) {
            $this -> days = $adminSetting -> password_change_days;
            $this -> enableChangePassword = $adminSetting -> enable_change_password;
        }

    }

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!$this -> enableChangePassword)
            return false;


        $user = User ::where('email', $this -> email) -> first();
        $password_changed_at = Carbon ::parse(($user -> password_changed_at) ? $user -> password_changed_at : $user -> created_at);
        if(Carbon ::now() -> diffInDays($password_changed_at) >= $this -> days)
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.Your password is older. Please change your password.', ['num' => $this -> days]);
    }

    public function getResult($param, $value)
    {
        $bool = $this -> passes($param, $value);
        $message = $this -> message();
        return array($bool, $message);
    }
}

