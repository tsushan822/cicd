<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 06/06/2018
 * Time: 10.25
 */

namespace App\Zen\Lease\Service;


use App\Zen\Lease\Calculate\IFRS\Asset\AssetClosingBalance;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Illuminate\Database\Eloquent\Model;

class MonthEndConversionService
{
    public static function monthEndDepreciationConversionRate($leaseExtension)
    {

        $baseCurrency = CurrencyService ::getCompanyBaseCurrency($leaseExtension -> lease -> entity_id);
        if($baseCurrency -> id == $leaseExtension -> lease -> currency_id)
            return null;
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($leaseExtension -> lease, $leaseExtension -> date_of_change);
        $rateAtBeginning = CurrencyConversion ::getRate($leaseExtension -> lease -> effective_date, $baseCurrency, $leaseExtension -> lease -> currency);
        if($lastFlow instanceof Model) {
            $newConversionRate = self ::calculateDepreciationRate($leaseExtension, $lastFlow);
        } else {
            $newConversionRate = $rateAtBeginning;
        }
        return $newConversionRate;
    }

    public static function monthEndLiabilityConversionRate($leaseExtension)
    {
        $baseCurrency = CurrencyService ::getCompanyBaseCurrency($leaseExtension -> lease -> entity_id);
        if($baseCurrency -> id == $leaseExtension -> lease -> currency_id)
            return null;
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($leaseExtension -> lease, $leaseExtension -> date_of_change);
        if($lastFlow instanceof Model) {
            $newConversionRate = self ::calculateLiabilityRate($leaseExtension, $lastFlow);
        } else {
            $rateAtBeginning = CurrencyConversion ::getRate($leaseExtension -> lease -> effective_date, $baseCurrency, $leaseExtension -> lease -> currency);
            $newConversionRate = $rateAtBeginning;
        }
        return $newConversionRate;
    }

    public static function getDepreciationConversionRate($leaseExtension)
    {
        return $leaseExtension -> depreciation_conversion_rate;

    }

    public static function calculateDepreciationRate($leaseExtension, $lastFlow)
    {
        $baseCurrency = CurrencyService ::getCompanyBaseCurrency($leaseExtension -> lease -> entity_id);
        $previousConversionRate = $lastFlow -> leaseExtension -> depreciation_conversion_rate;
        $firstFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($leaseExtension -> lease, $leaseExtension -> id);
        $depreciationOpeningValue = (float)$firstFlow -> depreciation_opening_balance;
        $lastDepreciationClosing = (new AssetClosingBalance($leaseExtension)) -> calculateLastDepreciation();
        $differenceInDepreciation = $depreciationOpeningValue - $lastDepreciationClosing;
        $rateAtChange = CurrencyConversion ::getRate($leaseExtension -> date_of_change, $baseCurrency, $leaseExtension -> lease
            -> currency);
        if($depreciationOpeningValue > $lastDepreciationClosing)
            $conventionRate = $depreciationOpeningValue / (($lastDepreciationClosing / $previousConversionRate) + ($differenceInDepreciation / $rateAtChange));
        else
            $conventionRate = $previousConversionRate;
        return $conventionRate;
    }

    public static function getLiabilityConversionRate($leaseExtension)
    {
        return $leaseExtension -> liability_conversion_rate;
    }

    public static function calculateLiabilityRate($leaseExtension, $lastFlow)
    {
        $baseCurrency = CurrencyService ::getCompanyBaseCurrency($leaseExtension -> lease -> entity_id);
        $previousConversionRate = $lastFlow -> leaseExtension -> liability_conversion_rate;
        $firstFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($leaseExtension -> lease, $leaseExtension -> id);
        $liabilityOpeningValue = $firstFlow -> liability_opening_balance;
        $lastLiabilityClosing = $lastFlow -> liability_closing_balance;
        $differenceInLiability = $liabilityOpeningValue - $lastLiabilityClosing;
        $rateAtChange = CurrencyConversion ::getRate($leaseExtension -> date_of_change, $baseCurrency, $leaseExtension -> lease -> currency);
        if($liabilityOpeningValue > $lastLiabilityClosing)
            $conventionRate = $liabilityOpeningValue / (($lastLiabilityClosing / $previousConversionRate) + ($differenceInLiability / $rateAtChange));
        else
            $conventionRate = $previousConversionRate;
        return $conventionRate;

    }
}