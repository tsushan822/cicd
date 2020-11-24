<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/06/2018
 * Time: 11.46
 */

namespace App\Zen\Report\Generate\Lease\Traits;


use App\Exceptions\CustomException;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Lease\Service\MonthEndConversionService;
use Illuminate\Database\Eloquent\Model;

trait CalculateMonthEndBalance
{
    public function calculateMonthlyDepreciation($lease, $monthDepreciation, $accountingDate)
    {
        $monthDepreciationBaseCurrency = $monthDepreciation;
        $baseCurrency = $this -> getCurrency($lease -> entity_id);
        if($baseCurrency -> id == $lease -> currency_id) {
            return $monthDepreciation;
        }
        $leaseExtensions = LeaseExtensionService ::earlierExtensionDate($accountingDate, $lease);
        if(!$leaseExtensions instanceof Model) {
            $monthDepreciationBaseCurrency = $this -> checkBaseCurrencyAndConvert($lease, $monthDepreciation, $accountingDate);
        } else {
            $monthDepreciationBaseCurrency = $this -> depreciationWithConversionRate($lease, $accountingDate, $leaseExtensions, $monthDepreciationBaseCurrency);
        }
        return $monthDepreciationBaseCurrency;
    }

    public function calculateMonthlyLiability($lease, $monthLiability, $accountingDate)
    {
        $monthLiabilityBaseCurrency = $monthLiability;
        $baseCurrency = $this -> getCurrency($lease -> entity_id);
        if($baseCurrency -> id == $lease -> currency_id) {
            return 0;
        }
        $leaseExtensions = LeaseExtensionService ::earlierExtensionDate($accountingDate, $lease);
        if(!$leaseExtensions instanceof Model) {
            $monthLiabilityBaseCurrency = $this -> checkBaseCurrencyAndConvert($lease, $monthLiability, $accountingDate);
        } else {
            $leaseFlow = LeaseFlowService ::leaseFlowAtGivenTime($lease, $accountingDate);
            if($leaseFlow) {
                $rate = MonthEndConversionService ::getLiabilityConversionRate($leaseExtensions);
                if($rate) {
                    $monthLiabilityBaseCurrency = $monthLiability / $rate;
                }

            }
        }
        return $monthLiabilityBaseCurrency - $lease -> total_liability_base_currency;
    }

    public function getAmountLiabilityConversionRate($lease, $amount, $accountingDate)
    {
        $baseCurrency = $this -> getCurrency($lease -> entity_id);
        if($baseCurrency -> id == $lease -> currency_id) {
            return 0;
        }
        $leaseExtensions = LeaseExtensionService ::earlierExtensionDate($accountingDate, $lease);
        if(!$leaseExtensions instanceof Model) {
            return $this -> checkBaseCurrencyAndConvert($lease, $amount, $accountingDate);
        } else {
            $leaseFlow = LeaseFlowService ::leaseFlowAtGivenTime($lease, $accountingDate);
            if($leaseFlow) {
                $rate = MonthEndConversionService ::getLiabilityConversionRate($leaseExtensions);
                if($rate) {
                    return $amount / $rate;
                }

            }
        }
        throw new CustomException('Problem with liability conversion rate, contact administrator');
    }

    public function depreciationWithConversionRate($lease, $accountingDate, $leaseExtension, $amount)
    {
        $leaseFlow = LeaseFlowService ::leaseFlowAtGivenTime($lease, $accountingDate);
        if($leaseFlow) {
            $rate = MonthEndConversionService ::getDepreciationConversionRate($leaseExtension);
            if($rate)
                $amount = $amount / $rate;
        }
        return $amount;
    }
}