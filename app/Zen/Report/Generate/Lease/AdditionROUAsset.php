<?php


namespace App\Zen\Report\Generate\Lease;


use App\Zen\Lease\Model\Lease;
use App\Zen\Report\Generate\GetCurrencyForLease;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;

class AdditionROUAsset extends GetCurrencyForLease
{
    use Exportable;
    protected $baseCurrencyId = null;
    protected $accountingDate;

    public function generateReport()
    {
        set_time_limit(150);
        $accountingDate = request() -> end_date;
        $accountingDate = Carbon ::parse($accountingDate) -> endOfMonth() -> toDateString();
        return $this -> getAllReportData($accountingDate);
    }

    public function getAllReportData($accountingDate)
    {
        $leases = Lease ::reportable() -> where(function ($query) {
            return $query -> where('payment_before_commencement_date', '!=', 0) -> orWhere('initial_direct_cost', '!=', 0) -> orWhere('cost_dismantling_restoring_asset', '!=', 0)
                -> orWhere('lease_incentives_received', '!=', 0) -> orWhere('residual_value', '!=', 0);
        }) -> where('effective_date', '<=', $accountingDate) -> where('maturity_date', '>', $accountingDate) -> get();

        foreach($leases as $lease) {
            if($lease -> payment_before_commencement_date) {
                $lease -> payment_before_commencement_date_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> payment_before_commencement_date, $lease -> effective_date);
            }

            if($lease -> initial_direct_cost) {
                $lease -> initial_direct_cost_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> initial_direct_cost, $lease -> effective_date);
            }

            if($lease -> cost_dismantling_restoring_asset) {
                $lease -> cost_dismantling_restoring_asset_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> cost_dismantling_restoring_asset, $lease -> effective_date);
            }

            if($lease -> lease_incentives_received) {
                $lease -> lease_incentives_received_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> lease_incentives_received, $lease -> effective_date);
            }

            if($lease -> residual_value) {
                $lease -> residual_value_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> residual_value, $lease -> effective_date);
            }
        }

        if(app('costCenterSplitAdmin')) {
            $leases = $this -> addCostCenterSplit($leases);
        }

        return $leases;
    }

    /**
     * @param $returnLeases
     * @param array $arrayToConvert
     * @return array $returnLeases
     */
    public function addCostCenterSplit($returnLeases, $arrayToConvert = [])
    {
        $i = 0;
        $arrayToConvert = count($arrayToConvert) ? $arrayToConvert : ['payment_before_commencement_date', 'payment_before_commencement_date_base_currency', 'initial_direct_cost',
            'initial_direct_cost_base_currency', 'cost_dismantling_restoring_asset', 'cost_dismantling_restoring_asset_base_currency', 'lease_incentives_received', 'lease_incentives_received_base_currency', 'residual_value', 'residual_value_base_currency'];
        foreach($returnLeases as $returnLease) {
            if($returnLease -> cost_center_split) {
                foreach($returnLease -> costCenters as $item) {

                    if(!empty(request() -> input('cost_center_id')) && !in_array($item -> id, request() -> input('cost_center_id')))
                        continue;

                    $newFlow = clone $returnLease;
                    foreach($arrayToConvert as $data) {
                        $newFlow -> $data = $returnLease -> $data * $item -> pivot -> percentage / 100;
                    }
                    $newFlow -> cost_center_name = $item -> short_name;
                    $returnLeases -> push($newFlow);
                }
                $returnLeases -> forget([$i]);
            }
            $i++;
        }

        return $returnLeases;
    }
}
