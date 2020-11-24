<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/01/2018
 * Time: 10.11
 */

namespace App\Zen\User\Dashboard;

use App\Zen\Setting\Model\Counterparty;

class TotalLimitUsage extends DashboardView
{

    public function getChartValue()
    {
        $baseCurrency = Counterparty ::parent() -> currency;
        $counterpartyWithLimit = $this->counterpartyWithLimit();
        $totalLimit = $this->findTotalLimit($counterpartyWithLimit, $baseCurrency);
        $totalLimitForGauge = [
            mYFormat(0, 2),
            mYFormat($totalLimit / 10, 2),
            mYFormat($totalLimit / 10 * 2, 2),
            mYFormat($totalLimit / 10 * 3, 2),
            mYFormat($totalLimit / 10 * 4, 2),
            mYFormat($totalLimit / 10 * 5, 2),
            mYFormat($totalLimit / 10 * 6, 2),
            mYFormat($totalLimit / 10 * 7, 2),
            mYFormat($totalLimit / 10 * 8, 2),
            mYFormat($totalLimit / 10 * 9, 2),
            mYFormat($totalLimit, 2)
        ];
        $limitUsed = $this->findLimitUsed();
        return array($totalLimitForGauge, $totalLimit, $limitUsed);
    }
}