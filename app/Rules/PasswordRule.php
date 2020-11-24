<?php

namespace App\Rules;

use App\Zen\Setting\Model\AdminSetting;
use App\Zen\User\Service\PasswordRegex;
use Illuminate\Contracts\Validation\Rule;

class PasswordRule implements Rule
{
    use PasswordRegex;
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
        return preg_match(config('password_validation.pattern'), (string)$value);
    }

    /*  public function returnArray()
      {
          $adminSetting = AdminSetting ::first();
          if($adminSetting instanceof AdminSetting) {
              if(!is_null($adminSetting -> min_password_length))
                  config(['password_validation.min_length' => $adminSetting -> min_password_length]);

              if(!is_null($adminSetting -> max_password_length))
                  config(['password_validation.max_length' => $adminSetting -> max_password_length]);

              if(!is_null($adminSetting -> password_criteria))
                  config(['password_validation.pattern' => $adminSetting -> password_criteria]);
          }
          return [
              'min:' . config('password_validation.min_length'),
              'max:' . config('password_validation.max_length'),
              'regex:' . config('password_validation.pattern'),
          ];
      }*/

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       $returnValue = $this->passwordRuleValue();
       $message = '';
       if($returnValue['one_small'])
           $message = $message.' '.trans('master.One small character,');

       if($returnValue['one_capital'])
           $message = $message.' '.trans('master.one capital character,');

       if($returnValue['one_special'])
           $message = $message.' '.trans('master.one special character,');

       if($returnValue['one_number'])
           $message = $message.' '.trans('master.one numeric value');

       return $message. ' is required';
    }
}
