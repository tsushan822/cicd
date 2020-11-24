<?php


namespace App\Zen\Lease\Service;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use Carbon\Carbon;

class LeaseAccruedInterest
{
    protected $amount;
    protected $lease;
    protected $accountingDate;
    protected $leaseFlow;


    /**
     * @param $amount
     * @return LeaseAccruedInterest
     */
    public function setAmount($amount): LeaseAccruedInterest
    {
        $this -> amount = $amount;
        return $this;
    }

    /**
     * @param $lease
     * @return LeaseAccruedInterest
     */
    public function setLease(Lease $lease): LeaseAccruedInterest
    {
        $this -> lease = $lease;
        return $this;
    }

    /**
     * @param mixed $accountingDate
     * @return LeaseAccruedInterest
     */
    public function setAccountingDate($accountingDate): LeaseAccruedInterest
    {
        $this -> accountingDate = $accountingDate;
        return $this;
    }

    /**
     * @param mixed $leaseFlow
     * @return LeaseAccruedInterest
     */
    public function setLeaseFlow(LeaseFlow $leaseFlow)
    {
        $this -> leaseFlow = $leaseFlow;
        return $this;
    }

    public function calculateAccruedValue()
    {

        //For monthly payment leases
        if($this -> lease -> lease_flow_per_year == 12 && Carbon ::parse($this -> leaseFlow -> start_date) -> format('M') == Carbon ::parse($this -> leaseFlow -> end_date) -> format('M')) {
            if($this -> leaseFlow -> payment_date > $this -> leaseFlow -> end_date) {
                return $this -> amount;
            }
            return 0;
        }

        if($this -> accountingDate >= $this -> leaseFlow -> payment_date)
            return 0;


        //For other than monthly payment leases
        if($this -> lease -> lease_flow_per_year != 12 && $this -> leaseFlow -> payment_date > $this -> leaseFlow -> end_date && $this -> accountingDate >  $this -> leaseFlow -> end_date) {
            return $this -> amount + self ::getAccruedValue();
        } else {
            return $this -> getAccruedValue();
        }
    }

    /**
     * @return float|int
     */
    public function getAccruedValue()
    {
        return $this -> amount * (Carbon ::parse($this -> accountingDate) -> diffInDays($this -> leaseFlow -> start_date))
            / (Carbon ::parse($this -> leaseFlow -> start_date) -> diffInDays($this -> leaseFlow -> end_date));

    }
}