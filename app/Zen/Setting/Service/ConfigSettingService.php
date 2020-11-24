<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 21/03/2018
 * Time: 16.40
 */

namespace App\Zen\Setting\Service;


use App\Exceptions\CustomException;
use App\Zen\Setting\Model\ConfigSetting;

class ConfigSettingService
{
    public static function shortForecastLength()
    {
        $shortForeCastLengthObj = ConfigSetting ::where('type', 'number_of_forecasting_days') -> first();
        if($shortForeCastLengthObj)
            return $shortForeCastLengthObj -> value_int;

        throw new CustomException('Short forecast length not set up');
    }

    public static function shortForecastStartDay()
    {
        $startDateObj = ConfigSetting ::where('type', 'short_forecast_starting_day') -> first();
        if($startDateObj)
            return $startDateObj -> value_date;

        throw new CustomException('Short forecast start day not set up');
    }

    public static function longForecastLength()
    {
        $longForeCastLengthObj = ConfigSetting ::where('type', 'number_of_forecasting_month') -> first();
        if($longForeCastLengthObj)
            return $longForeCastLengthObj -> value_int;

        throw new CustomException('Long forecast length not set up');
    }

    public static function longForecastStartMonth()
    {
        $startMonthObj = ConfigSetting ::where('type', 'long_forecast_starting_month') -> first();
        if($startMonthObj)
            return $startMonthObj -> value_date;

        throw new CustomException('Long forecast start month not set up');
    }
}