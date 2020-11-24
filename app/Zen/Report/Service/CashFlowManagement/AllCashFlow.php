<?php

namespace App\Zen\Report\Service\CashFlowManagement;


use App\Zen\Guarantee\Model\Guarantee;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Report\Generate\FxDeal\FxRealisedReport;
use App\Zen\Report\Generate\Guarantee\GuaranteePaymentReport;
use App\Zen\Report\Generate\Loan\HistoricCashFlow;

abstract class AllCashFlow
{
    protected $startDate;
    protected $endDate;

    /**
     * AllCashFlow constructor.
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate)
    {
        $this -> startDate = $startDate;
        $this -> endDate = $endDate;
    }

    public function getLoanFlows()
    {
        list($dealFlowsForStartEnd, $mirrorDealFlowsForStartEnd) = (new HistoricCashFlow()) -> getDealFlows($this -> startDate, $this -> endDate);
        return $dealFlowsForStartEnd;
    }

    public function getLeaseFlows()
    {
        $leaseIdArray = Lease ::reportable() -> pluck('id') -> toArray();
        $leaseFlows = LeaseFlow ::with('lease', 'lease.entity') -> whereIn('lease_id', $leaseIdArray) -> whereBetween('payment_date',
            [$this -> startDate, $this -> endDate]) -> orderBy('payment_date') -> get();
        return $leaseFlows;
    }

    public function getGuaranteeFlows()
    {
        $guaranteeFlows = (new GuaranteePaymentReport()) -> getGuaranteeFlows($this -> startDate, $this -> endDate);
        return $guaranteeFlows;
    }

    public function getFxFlows()
    {
        $realisedFxs = (new FxRealisedReport()) -> getFxDeals($this -> startDate, $this -> endDate);
        return $realisedFxs;
    }
}