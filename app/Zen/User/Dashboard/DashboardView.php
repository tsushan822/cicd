<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 29/12/2017
 * Time: 14.35
 */

namespace App\Zen\User\Dashboard;

use App\Zen\Guarantee\Model\Guarantee;
use App\Zen\Setting\Convention\BusinessDayConvention\DateTimeConversion;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Carbon\Carbon;

abstract class DashboardView
{
    use DateTimeConversion;

    public abstract function getChartValue();

    public function counterpartyWithLimit()
    {
        $counterpartiesWithGuaranteeLimit = Counterparty ::where('limit_guarantee', '>', '0') -> get();
        return $counterpartiesWithGuaranteeLimit;
    }

    public function findTotalLimit($counterpartiesWithGuaranteeLimit, $baseCurrency)
    {
        $totalLimit = 0;
        foreach($counterpartiesWithGuaranteeLimit as $counterparty) {
            if($counterparty -> currency_id == $baseCurrency -> id) {
                $totalLimit = $totalLimit + ($counterparty -> limit_guarantee / 1000000);
            } else {
                $convertedMaxAmount = CurrencyConversion ::currencyAmountToBaseAmount($counterparty -> limit_guarantee,
                    Carbon ::today() -> toDateString(), $baseCurrency, $counterparty -> currency);
                $totalLimit = $totalLimit + $convertedMaxAmount / 1000000;
            }
        }
        return $totalLimit;
    }

    public function findLimitUsed()
    {
        $baseCurrency = CurrencyService::getCompanyBaseCurrency();
        $limitUsed = 0;
        $guarantees = Guarantee ::where('status', 4)
            -> where(function ($query) {
                $query -> where('guarantees.maturity_date', '>=', Carbon ::today() -> toDateString())
                    -> orWhere('has_end_date', 1);
            })
            -> join('counterparties', 'guarantees.guarantor_id', '=', 'counterparties.id')
            -> where('counterparties.limit_guarantee', '>', 0) -> get();
        foreach($guarantees as $guarantee) {
            if($baseCurrency -> id == $guarantee -> currency_id) {
                $limitUsed = $limitUsed + $guarantee -> max_amount;
            } else {
                $convertedMaxAmount = CurrencyConversion :: currencyAmountToBaseAmount($guarantee -> max_amount,
                    Carbon ::today() -> toDateString(), $baseCurrency, $guarantee -> currency);
                $limitUsed = $limitUsed + $convertedMaxAmount;
            }
        }
        return $limitUsed / 1000000;
    }

    public function getLabel($counterpartiesWithGuaranteeLimit)
    {
        $labels = collect();
        foreach($counterpartiesWithGuaranteeLimit as $counterparty) {
            $labels[] = $counterparty -> short_name;
        }
        return $labels;
    }
}