<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 13/08/2018
 * Time: 15.08
 */

namespace App\Zen\Setting\Calculate\DateTime;

class GetData
{
    public static function getAllPaymentDays()
    {
        $returnArray = [];
        foreach(range(1, 31) as $i)
            $returnArray[$i] = $i;

        return $returnArray;
    }

    public static function getPaymentMonth()
    {
        $returnArray = [];
        $returnArray[0] = trans('master.Same month');
        $returnArray[-1] = trans('master.Previous month');
        $returnArray[1] = trans('master.Next month');
        $returnArray[2] = trans('master.Two months later');

        return $returnArray;
    }
}