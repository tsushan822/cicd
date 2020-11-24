<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/01/2018
 * Time: 10.57
 */

namespace App\Zen\User\Dashboard;


use App\Zen\Setting\Model\Counterparty;
use Carbon\Carbon;

class LeaseMaturity extends DashboardView
{

    public function getChartValue()
    {
        $counterpartyWithLimit = $this -> counterpartyWithLimit();
        $labels = $this -> getLabel($counterpartyWithLimit);

        $baseCurrency = Counterparty ::parent() -> currency;
        $counterpartyWithLimit = $this->counterpartyWithLimit();
        $totalLimit = $this->findTotalLimit($counterpartyWithLimit, $baseCurrency);

        $default = collect();
        $lastMonth = Carbon ::today() -> subMonth();
        $default[] = $lastMonth -> format('M-Y');
        $default[] = $lastMonth -> addYears(1) -> format('M-Y');

        $firstMonth = Carbon ::today() -> subYear();
        $rangeMonths = collect();
        $insertMonth = $firstMonth;
        $maxDate = $lastMonth->addYears(5);
        while($insertMonth < $maxDate)
        {
            $rangeMonths[] = $insertMonth->format('M-Y');
            $insertMonth = $insertMonth->addMonthsNoOverflow(1);
        }
        return array($default,$rangeMonths, $totalLimit, $labels);
    }
}