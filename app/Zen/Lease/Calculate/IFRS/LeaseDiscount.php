<?php

namespace App\Zen\Lease\Calculate\IFRS;


use App\Zen\Lease\Model\Lease;
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 04/05/2018
 * Time: 10.37
 */
class LeaseDiscount
{

    /**
     * @var Lease
     */
    protected $lease;
    protected $interestCalculationMethod;

    public function __construct(Lease $lease)
    {
        $this -> lease = $lease;
        $this -> interestCalculationMethod = $this -> lease -> leaseType -> interest_calculation_method;
    }

    public function calculateValue($rate, $leaseFlow, $months, $numberOfMonthsPerYear)
    {
        $amount = $leaseFlow['fixed_amount'];
        if($this -> interestCalculationMethod == 'Simple') {
            $data = pow(1 + ($rate / ($numberOfMonthsPerYear * 100)), $months);
            $discountedAmount = $amount / $data;
        } elseif($this -> interestCalculationMethod == 'Simple actual days') {
            $startDate = $leaseFlow['start_date'];
            $endDate = $leaseFlow['end_date'];
            $diffInDays = Carbon ::parse($endDate) -> diffInDays($startDate);
            $discountedAmount = $amount / pow((1 + $rate / 100), ($diffInDays / 365));
        } else {
            $data = pow(1 + $rate / 100, $months / $numberOfMonthsPerYear);
            $discountedAmount = $amount / $data;
        }
        return $discountedAmount;
    }


    /*public function calculateValue($rate, $amount, $months, $numberOfMonthsPerYear)
    {
        if($this -> interestCalculationMethod == 'Simple') {
            $data = pow(1 + ($rate / ($numberOfMonthsPerYear * 100)), $months);
            $discountedAmount = $amount / $data;
        } else {
            $data = pow(1 + $rate / 100, $months / $numberOfMonthsPerYear);
            $discountedAmount = $amount / $data;
        }

        return $discountedAmount;
    }*/

    public function calculateInterest($leaseFlow, $amount)
    {
        $rate = $leaseFlow -> leaseExtension -> lease_extension_rate;
        $numberOfMonthsPerYear = $leaseFlow -> lease -> lease_flow_per_year;
        if($this -> interestCalculationMethod == 'Simple') {
            $discountedAmount = $amount * 1 / $numberOfMonthsPerYear * $rate / 100;
        } elseif($this -> interestCalculationMethod == 'Simple actual days') {
            $diffInDays = Carbon ::parse($leaseFlow -> end_date) -> diffInDays($leaseFlow -> start_date);
            $rate1 = pow((1 + $rate / 100), ($diffInDays / 365)) - 1;
            $discountedAmount = $amount * $rate1;
        } else {
            $rate1 = pow(1 + $rate / 100, (1 / $numberOfMonthsPerYear)) - 1;
            $discountedAmount = $amount * $rate1;
        }
        return $discountedAmount;
    }

    public function calculateVariables($rate, $amount, $numberOfMonthsPerYear, $number)
    {

        if($this -> interestCalculationMethod == 'Simple') {
            $data = pow(1 + ($rate / ($numberOfMonthsPerYear * 100)), $number);
            $value = $amount / $data;
        } else {

            $value = $amount / pow(1 + $rate / 100, $number / $numberOfMonthsPerYear);
        }

        return $value;
    }
}