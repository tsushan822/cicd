<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/03/2018
 * Time: 17.01
 */

namespace App\Zen\Setting\Calculate;


class SimpleInterest
{
    public static function calculateSimpleInterest($principal, $interestRate, $rate)
    {
        $interest = $principal * ($interestRate / 100) * $rate;
        return $interest;
    }

    public static function calculateWithDayConvention($principal, $interestRate, $actualNumberOfDays, $numberOfDaysYear)
    {
        $interest = static::calculateSimpleInterest($principal , $interestRate , $actualNumberOfDays / $numberOfDaysYear);
        return $interest;
    }
}