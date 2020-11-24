<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 22/11/2017
 * Time: 11.42
 */

namespace App\Zen\Setting\Convention\BusinessDayConvention;


use Carbon\Carbon;

trait DateTimeConversion
{
    public function getAllNextBusinessDays($numberOfDays, $startDate = null)
    {
        $calculatedDay = Carbon ::parse($this -> getStartDate($startDate));
        $returnArray = [];
        $totalDays = intval($numberOfDays * 7 / 5) + 2;
        foreach(range(0, $totalDays) as $day) {
            if($calculatedDay -> isWeekend())
                $calculatedDay = $calculatedDay -> nextWeekday();
            $returnArray[] = $calculatedDay -> toDateString();
            $calculatedDay = $calculatedDay -> addDay();
            if(count($returnArray) >= $numberOfDays)
                break;
        }
        return $returnArray;
    }

    public function getStartDate($startDate)
    {
        if(!$startDate)
            $startDate = Carbon ::today() -> toDateString();

        return $startDate;
    }

    public function getStartDateIfWeekend($startDate)
    {
        if($startDate)
            return Carbon ::parse($startDate) -> isWeekday() ? Carbon ::parse($startDate) -> toDateString() :
                Carbon ::parse($startDate) -> nextWeekday() -> toDateString();
        else
            return Carbon ::today() -> isWeekday() ? Carbon ::today() -> toDateString() : Carbon ::today() -> nextWeekday() -> toDateString();
    }

    public function moveIfWeekend($givenDate)
    {
        if(Carbon ::parse($givenDate) -> isWeekend()) {
            return Carbon ::parse($givenDate) -> nextWeekday() -> toDateString();
        }
        return $givenDate;
    }

    public function getNextMonths($numberOfMonths, $startDate = null)
    {
        $calculatedDay = Carbon ::parse($this -> getStartDate($startDate));
        $returnArray = [];
        foreach(range(1, $numberOfMonths) as $month) {
            $returnArray[] = $calculatedDay -> format('Y-m');
            $calculatedDay = $calculatedDay -> addMonth();
        }
        return $returnArray;
    }

    public function numberOfMonthEndInBetween($startDate, $endDate)
    {
        //Since it is not taking end day, we will add a day here to the end date
        $endDate = Carbon ::parse($endDate) -> addDay() -> toDateString();
        return Carbon ::parse($startDate) -> diffInDaysFiltered(function (Carbon $date) {
            return $date -> isLastOfMonth();
        }, $endDate);
    }
}