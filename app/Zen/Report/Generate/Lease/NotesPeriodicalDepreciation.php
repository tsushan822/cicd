<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/06/2018
 * Time: 16.14
 */

namespace App\Zen\Report\Generate\Lease;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Convention\BusinessDayConvention\DateTimeConversion;
use Carbon\Carbon;

class NotesPeriodicalDepreciation extends GetCurrencyForLease
{

    use  DateTimeConversion;

    function generateReport()
    {
        $startDate = request() -> start_date;
        $endDate = request() -> end_date;
        $leases = Lease ::reportable() -> get();

        foreach($leases as $lease) {
            $arr = [];
            $amount = 0;
            $leaseExtensions = LeaseExtension ::where('extension_start_date', '<', $endDate) -> where('extension_end_date', '>', $startDate)
                -> where('lease_id', $lease -> id) -> get();
            if(count($leaseExtensions)) {
                $i = 0;
                $calculationStartDate = $startDate;
                foreach($leaseExtensions as $item) {
                    if($item -> lease_extension_type == 'Terminate Lease')
                        continue;
                    $calculationStartDate = $item -> extension_start_date < $startDate ? $calculationStartDate : $item -> extension_start_date;
                    $calculationEndDate = $endDate;
                    if(isset($leaseExtensions[++$i]) === true) {
                        $calculationEndDate = $leaseExtensions[$i] -> extension_start_date;
                    }
                    $newStartDate = $calculationStartDate;
                    $arr[] = [
                        'start_date' => $newStartDate,
                        'end_date' => $calculationEndDate,
                        'extension_id' => $item -> id,
                    ];
                    $calculationStartDate = $newStartDate;
                }
            }
            $amountBaseCurrency = 0;
            foreach($arr as $item) {
                $months = $this -> numberOfMonthEndInBetween($item['start_date'], $item['end_date']);
                $firstLeaseFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($lease, $item['extension_id']);
                $monthDepreciation = LeaseFlowService ::monthDepreciation($firstLeaseFlow);
                $amount = ($monthDepreciation * $months);
                $amountBaseCurrency += $this -> calculateMonthlyDepreciation($lease, $amount, $item['end_date']);
            }
            $lease -> sum_base_currency = $amountBaseCurrency;
        }
        return $leases;
    }
}