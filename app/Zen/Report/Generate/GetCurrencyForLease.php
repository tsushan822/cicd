<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 15.27
 */

namespace App\Zen\Report\Generate;

use App\Exceptions\CustomException;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Report\Generate\Lease\Traits\CalculateMonthEndBalance;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Illuminate\Support\Facades\Lang;

abstract class GetCurrencyForLease implements GenerateReport
{
    protected $baseCurrencyId = null;
    protected $baseCurrency = null;
    protected $crossCurrencyId = null;
    protected $crossCurrency = null;

    use CalculateMonthEndBalance;

    abstract function generateReport();

    public function checkBaseCurrencyAndConvert($lease, $amount, $date = null)
    {
        $accountingDate = $date ?: $lease -> effective_date;
        $baseCurrency = $this -> getBaseCurrency($lease -> entity_id);
        if($baseCurrency -> id != $lease -> currency_id)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, $lease -> currency);

        return $amount;
    }

    public function convertMonthReport($amount, $date = null)
    {
        if($this -> baseCurrencyId != $this -> crossCurrencyId)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $date, $this -> baseCurrency, $this -> crossCurrency);

        return $amount;
    }

    public function checkBaseCurrencyAndConvertWithoutLease($amount, $date, $currencyId)
    {
        $accountingDate = $date;
        $baseCurrency = $this -> getBaseCurrency();
        if($baseCurrency -> id != $currencyId && $amount)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, Currency ::findOrFail($currencyId));

        return $amount;
    }

    public function getCurrency($entityId = null)
    {
        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

    public function getBaseCurrency($entityId = null)
    {
        if(request() -> get('currency_id')) {
            return Currency ::findOrFail(request() -> get('currency_id'));
        }

        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

    public function convertInLiabilityRate($amount, $leaseExtension, $lease)
    {
        if($lease -> currency_id == $lease -> entity -> currency_id) {
            return $amount;
        }
        if(!$leaseExtension -> liability_conversion_rate)
            throw new CustomException(Lang ::get('Liability conversion rate is missing in lease ' . $leaseExtension -> lease_id));

        return $amount / ($leaseExtension -> liability_conversion_rate);
    }

    public function convertInDepreciationRate($amount, $leaseExtension, $lease)
    {
        if($lease -> currency_id == $lease -> entity -> currency_id) {
            return $amount;
        }

        if(!$leaseExtension -> liability_conversion_rate)
            throw new CustomException(Lang ::get('Depreciation conversion rate is missing in lease ' . $leaseExtension -> lease_id));

        return $amount / ($leaseExtension -> depreciation_conversion_rate);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function getAllChanges($startDate, $endDate)
    {
        $leaseIdArray = Lease ::reportable() -> pluck('id') -> toArray();
        $leaseExtensions = LeaseExtension :: with('lease', 'lease.entity') -> whereBetween('date_of_change', [$startDate, $endDate]) -> whereIn('lease_id', $leaseIdArray) -> orderBy('extension_start_date') -> get();
        return $leaseExtensions;
    }

    /**
     * @param $baseCurrencyId
     * @return $this
     */
    public function setBaseCurrencyId($baseCurrencyId)
    {
        $this -> baseCurrencyId = $baseCurrencyId;
        $this -> setBaseCurrency(Currency ::findOrFail($baseCurrencyId));
        return $this;
    }

    /**
     * @param $baseCurrency
     * @return $this
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this -> baseCurrency = $baseCurrency;
        return $this;
    }

    /**
     * @param $crossCurrencyId
     * @return $this
     */
    public function setCrossCurrencyId($crossCurrencyId)
    {
        $this -> crossCurrencyId = $crossCurrencyId;
        $this -> setCrossCurrency(Currency ::findOrFail($crossCurrencyId));
        return $this;
    }

    /**
     * @param $crossCurrency
     * @return $this
     */
    public function setCrossCurrency($crossCurrency)
    {
        $this -> crossCurrency = $crossCurrency;
        return $this;
    }

    public function eligibleLeaseReport($startDate, $endDate)
    {
        return Lease ::where('effective_date', '<', $endDate) -> where('maturity_date', '>', $startDate);
    }

    public function eligibleLeaseMonthEnd($accountingDate)
    {
        return Lease ::with('leaseFlow', 'leaseExtension') -> where('effective_date', '<', $accountingDate)
            -> where('maturity_date', '>=', $accountingDate);

    }
}