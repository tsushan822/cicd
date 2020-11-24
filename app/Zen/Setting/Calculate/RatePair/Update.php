<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 06/08/2018
 * Time: 13.23
 */

namespace App\Zen\Setting\Calculate\RatePair;

use App\Zen\Setting\Model\FxRate;
use App\Zen\Setting\Model\FxRatePair;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\FxRateService;

class Update
{
    /**
     * @throws \App\Exceptions\CustomException
     */
    public static function updateRatePair():bool
    {
        $ratePairs = FxRatePair ::all();
        foreach($ratePairs as $ratePair) {
            self :: updateRateOfGivenCurrency($ratePair -> base_currency, $ratePair -> converting_currency, $ratePair -> referencing_currency);
        }
        return true;
    }

    /**
     * @param $baseCurrencyId
     * @param $convertingCurrencyId
     * @param $referenceCurrencyId
     * @param null $accountingDate
     * @return bool
     * @throws \App\Exceptions\CustomException
     */
    public static function updateRateOfGivenCurrency(int $baseCurrencyId, int $convertingCurrencyId, int $referenceCurrencyId): bool
    {

        $accountingDate = today() -> toDateString();
        $rateBase = CurrencyConversion ::getRateForGivenDay($accountingDate, $referenceCurrencyId, $baseCurrencyId);
        $rateConverting = CurrencyConversion ::getRateForGivenDay($accountingDate, $referenceCurrencyId, $convertingCurrencyId);
        if($rateConverting instanceof FxRate && $rateBase instanceof FxRate){
            $rateConverting = $rateConverting -> rate_bid;
            $rateBase = $rateBase -> rate_bid;
            $rate = $rateConverting / $rateBase;

            FxRateService ::createOrUpdateRate($baseCurrencyId, $convertingCurrencyId, $rate, $accountingDate);
        }
        return true;
    }
}