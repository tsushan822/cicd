<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 11.11
 */

namespace App\Zen\Setting\Calculate\DateTime\Traits;


use Carbon\Carbon;

trait PaymentDayCalculation
{
    public static function paymentDayCalculationWithMonthAdjustment($date, $day, $month = 0, $weekendAcceptFromDataBase = true)
    {
        if($month) {
            $date = Carbon ::parse($date) -> addMonthsNoOverflow($month) -> toDateString();
        }
        $date = self ::paymentDayCalculation($date, $day, $weekendAcceptFromDataBase);
        $returnDate = $date;
        return $returnDate;
    }

    public static function paymentDayCalculation($date, $day, $weekendAcceptFromDataBase = true)
    {
        $returnDate = Carbon ::parse($date) -> format('Y-m-' . $day);
        $returnDate = Carbon ::parse($returnDate) -> toDateString();
        if($date < $returnDate)
            return Carbon ::parse($date) -> endOfMonth() -> toDateString();
        return $returnDate;
    }

    public static function weekendAcceptFromDataBase()
    {
        return true;
    }

}