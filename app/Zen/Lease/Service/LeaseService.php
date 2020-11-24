<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 15/05/2018
 * Time: 12.17
 */

namespace App\Zen\Lease\Service;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\User\Dashboard\Lease\LeaseFlowDashboard;
use Carbon\Carbon;

class LeaseService
{
    public static function currentLiability($calculationDate = null, $leaseIdCriteria = null)
    {
        if(!$calculationDate)
            $calculationDate = today() -> endOfMonth() -> toDateString();

        $baseCurrency = LeaseFlowDashboard ::getCurrency();
        $currencies = Lease ::has('leaseExtension') -> where('effective_date', '<', $calculationDate) -> where('maturity_date', '>=', $calculationDate) -> distinct() -> pluck('currency_id') -> toArray();
        $totalLiability = 0;
        foreach($currencies as $currency) {
            $query = Lease ::has('leaseFlow') -> where('effective_date', '<', $calculationDate) -> where('maturity_date', '>=', $calculationDate) -> where('currency_id', $currency) -> reportable();
            if($leaseIdCriteria) {
                $query = $query -> whereIn('id', $leaseIdCriteria);
            }
            $leaseIdArray = $query -> pluck('id') -> toArray();
            $liabilityClosing = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('end_date', '=', $calculationDate) -> sum('liability_closing_balance');
            $liabilityClosingArray = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('end_date', '=', $calculationDate) -> pluck('lease_id') -> toArray();

            $result = array_diff($leaseIdArray, $liabilityClosingArray);
            $liabilityOpening = 0;
            $leasesRemaining = Lease ::has('leaseFlow') -> whereIn('id', $result) -> get();
            foreach($leasesRemaining as $item) {
                $lastFlowPresentWithOpening = LeaseFlowService ::leaseFlowPresentWithOpening($item -> id, Carbon ::parse($calculationDate) -> toDateString());
                $liabilityOpening += $lastFlowPresentWithOpening -> liability_opening_balance;
            }
            $liability = $liabilityClosing + $liabilityOpening;
            $totalLiability += CurrencyConversion ::currencyAmountToBaseAmount($liability, $calculationDate, $baseCurrency, Currency ::findOrFail($currency));
        }
        return array($totalLiability);
    }

    public static function getAccruedInterestPerLease($lease, $calculationDate)
    {
        $accruedInterestValue = 0;

        $leaseFlowEarlier = LeaseFlow ::where('start_date', '<', $calculationDate) -> orderBy('start_date', 'desc') -> where('lease_id', $lease -> id) -> first();
        $leaseFlowLater = LeaseFlow ::where('start_date', '>', $calculationDate) -> orderBy('start_date', 'asc') -> where('lease_id', $lease -> id) -> first();
        if($leaseFlowEarlier && $leaseFlowLater && checkDateEarlierSameMonth($leaseFlowEarlier -> payment_date, $calculationDate)) {
            $differenceInDays = Carbon ::parse($leaseFlowEarlier -> end_date) -> diffInDays(Carbon ::parse($calculationDate));
            $differenceInTwoPayments = Carbon ::parse($leaseFlowEarlier -> start_date) -> diffInDays(Carbon ::parse($leaseFlowLater -> start_date));
            $amount = $leaseFlowEarlier -> interest_cost;
            if($differenceInTwoPayments && $calculationDate != $leaseFlowEarlier -> payment_date)
                $accruedInterestValue = $amount - ($amount * $differenceInDays / $differenceInTwoPayments);
        }
        return $accruedInterestValue;
    }

    public function getCurrency($entityId = null)
    {
        return LeaseFlowDashboard ::getCurrency();
    }

    public function checkBaseCurrencyAndConvert($lease, $amount, $date = null)
    {
        $accountingDate = $date ?: $lease -> effective_date;
        $baseCurrency = $this -> getCurrency($lease -> entity_id);
        if($baseCurrency -> id != $lease -> currency_id)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, $lease -> currency);

        return $amount;
    }
}