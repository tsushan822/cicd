<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 19/03/2019
 * Time: 15.01
 */

namespace App\Zen\User\Service;

use App\Zen\Setting\Model\AdminSetting;

trait PasswordRegex
{
    public function passwordRuleValue()
    {
        $passwordRule = config('password_validation.pattern');

        if(config('website_id')) {
            $adminSetting = AdminSetting ::first();
            if($adminSetting instanceof AdminSetting && $adminSetting -> password_criteria)
                $passwordRule = $adminSetting -> password_criteria;
        }

        $returnValue['one_small'] = strpos($passwordRule, '(?=.*[a-z])') ? true : false;

        $returnValue['one_capital'] = strpos($passwordRule, '(?=.*[A-Z])') ? true : false;

        $returnValue['one_number'] = strpos($passwordRule, '(?=.*\d)') ? true : false;

        $returnValue['one_special'] = strpos($passwordRule, '(?=.*(_|[^\w]))') ? true : false;

        return $returnValue;
    }
}