<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 20/04/2018
 * Time: 14.00
 */

namespace App\Zen\Setting\Service\Currency;

use App\Exceptions\CustomException;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\FxRate;
use Carbon\Carbon;

class CurrencyConversion
{

    /**
     * @param $amount
     * @param $accountingDate
     * @param $crossCurrency
     * @param $baseCurrency
     * @param int $findPrevious
     * @param bool $includeToday
     * @return float|int
     * @throws CustomException
     */
    public static function currencyAmountToBaseAmount($amount, $accountingDate, $crossCurrency, $baseCurrency, $findPrevious = -1, $includeToday = false)
    {
        if($baseCurrency -> id == $crossCurrency -> id)
            return $amount;

        $rate = self :: getRate($accountingDate, $baseCurrency, $crossCurrency, $findPrevious, $includeToday);

        if($rate) {
            return static ::getAmount($rate, $amount);
        }

        throw new CustomException(trans('master.Rate not found for given date'));
    }

    /**
     * @param $amount
     * @param $accountingDate
     * @param $baseCurrency
     * @param $crossCurrency
     * @param int $findPrevious
     * @param bool $includeToday
     * @return float|int
     * @throws CustomException
     */
    public static function getAmountWithZero($amount, $accountingDate, $baseCurrency, $crossCurrency, $findPrevious = -1, $includeToday = false)
    {
        $rate = self :: getRate($accountingDate, $baseCurrency, $crossCurrency, $findPrevious, $includeToday);
        if($rate)
            return self :: getAmount($rate, $amount);

        return 0;
    }

    /**
     * @param $amount
     * @param $accountingDate
     * @param $baseCurrency
     * @param $crossCurrency
     * @return array
     * @throws CustomException
     */
    public function getAmountRate($amount, $accountingDate, $baseCurrency, $crossCurrency)
    {
        $rate = $this -> getRate($accountingDate, $baseCurrency, $crossCurrency);
        if($rate) {
            $amount = $this -> getAmount($rate, $amount);
            return [$amount, $rate];
        }
        return [0, 0];
    }

    /**
     * @param $accountingDate
     * @param Currency $baseCurrency
     * @param Currency $crossCurrency
     * @param int $findPrevious
     * @param bool $includeToday
     * @return float|int
     * @throws CustomException
     */
    public static function getRate($accountingDate, Currency $baseCurrency, Currency $crossCurrency, $findPrevious = -1, $includeToday = false)
    {
        //If both currency same return amount
        if($baseCurrency -> id == $crossCurrency -> id)
            throw new CustomException(trans('master.Rate cannot be find for given pair'));

        if(Carbon ::parse($accountingDate) -> isToday() && $includeToday == false) {
            $accountingDate = Carbon ::today() -> previousWeekday() -> toDateString();
        }


        $rate = self :: getRateForGivenDay($accountingDate, $baseCurrency -> id, $crossCurrency -> id);
        if($rate instanceof FxRate) {
            return $rate -> rate_bid;
        }

        if($findPrevious) {
            //Find previous date
            $rate = self :: getRateFurtherBefore($accountingDate, $baseCurrency, $crossCurrency, $findPrevious);
            if($rate) {
                return $rate -> rate_bid;
            }
        }

        $rate = self :: getRateForGivenDay($accountingDate, $crossCurrency -> id, $baseCurrency -> id);
        if($rate instanceof FxRate) {
            return 1 / $rate -> rate_bid;

        }

        if($findPrevious) {
            //Check with the cross currency
            $rate = self :: getRateFurtherBefore($accountingDate, $crossCurrency, $baseCurrency, $findPrevious);
            if($rate) {
                return 1 / $rate -> rate_bid;
            }
        }

        throw new CustomException(trans('master.Rate could not be found for',['baseCurrency' => $baseCurrency -> iso_4217_code,
            'crossCurrency' => $crossCurrency -> iso_4217_code,'accountingDate' => $accountingDate]));
    }

    /**
     * @param $accountingDate
     * @param $baseCurrency
     * @param $crossCurrency
     * @param $findPrevious
     * @param bool $throwException
     * @return bool
     * @throws CustomException
     */
    public static function getRateFurtherBefore($accountingDate, $baseCurrency, $crossCurrency, $findPrevious, $throwException = false)
    {
        //If the rate is not found for the day find previous
        $rateQuery = Fxrate ::where('ccy_base_id', $baseCurrency -> id) -> where('ccy_cross_id', $crossCurrency -> id)
            -> where('date', '<', $accountingDate) -> orderBy('date', 'desc');
        if($findPrevious != -1) {
            $minDate = Carbon ::parse($accountingDate) -> subDays($findPrevious) -> toDateString();
            $rateQuery = $rateQuery -> where('date', '>', $minDate);
        }
        $rate = $rateQuery -> first();
        if($rate) {
            return $rate;
        }

        if($throwException)
            throw new CustomException(trans('master.Previous rate history for this pair not found before',['accountingDate' => $accountingDate]));

        return false;
    }

    /**
     * @param $accountingDate
     * @param $baseCurrencyId
     * @param $crossCurrencyId
     * @param bool $throwException
     * @throws CustomException
     * @return mixed
     */
    public static function getRateForGivenDay(string $accountingDate, int $baseCurrencyId, int $crossCurrencyId, bool $throwException = false)
    {
        $rate = Fxrate ::where('ccy_base_id', $baseCurrencyId) -> where('ccy_cross_id', $crossCurrencyId)
            -> where('date', '=', $accountingDate) -> first();

        if(!$rate instanceof FxRate && $throwException) {

            throw new CustomException(trans('master.Rate not found for the given pair on' ,['accountingDate' => $accountingDate]));

        }
        return $rate;
    }

    /**
     * @param $rate
     * @param $amount
     * @return float|int
     * @throws CustomException
     */
    public static function getAmount($rate, $amount)
    {

        if($rate)
            return $amount * $rate;

        throw new CustomException(trans("master.The currency pair doesn't match."));
    }
}