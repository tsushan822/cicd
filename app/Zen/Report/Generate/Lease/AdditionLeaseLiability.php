<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 16.18
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Report\Generate\GetCurrencyForLease;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;

class AdditionLeaseLiability extends GetCurrencyForLease
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
            return $query -> where('exercise_price', '!=', 0) -> orWhere('residual_value_guarantee', '!=', 0) -> orWhere('penalties_for_terminating', '!=', 0);
        }) -> where('effective_date', '<=', $accountingDate) -> where('maturity_date', '>', $accountingDate) -> get();

        foreach($leases as $lease) {
            if($lease -> exercise_price) {
                $lease -> exercise_price_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> exercise_price, $accountingDate);
            }

            if($lease -> residual_value_guarantee) {
                $lease -> residual_value_guarantee_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> residual_value_guarantee, $accountingDate);
            }

            if($lease -> penalties_for_terminating) {
                $lease -> penalties_for_terminating_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> penalties_for_terminating, $accountingDate);
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
        $arrayToConvert = count($arrayToConvert) ? $arrayToConvert : ['exercise_price', 'exercise_price_base_currency', 'residual_value_guarantee', 'residual_value_guarantee_base_currency', 'penalties_for_terminating', 'penalties_for_terminating_base_currency'];
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