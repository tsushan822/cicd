<?php


namespace App\Rules\Common;


class RuleService
{
    public static function maxMinNum()
    {
        return ['max:999999999999.999999', 'min:-999999999999.999999'];
    }
}