<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 15/05/2018
 * Time: 12.05
 */

namespace App\Zen\User\Dashboard\Chart;


use Carbon\Carbon;

abstract class RangeCalculator
{
    abstract function getChartData();

    public function range()
    {
        $totalLimit = 0;
        $labels = [];
        $default = collect();
        $lastMonth = Carbon ::today() -> subMonth();
        $default[] = $lastMonth -> format('M-Y');
        $default[] = $lastMonth -> addYears(2) -> format('M-Y');

        $firstMonth = Carbon ::today() -> subYear();
        $rangeMonths = collect();
        $insertMonth = $firstMonth;
        $maxDate = $lastMonth->addYears(8);
        while($insertMonth < $maxDate)
        {
            $rangeMonths[] = $insertMonth->format('M-Y');
            $insertMonth = $insertMonth->addMonths(1);
        }

        return array($default,$rangeMonths, $totalLimit, $labels);
    }
}