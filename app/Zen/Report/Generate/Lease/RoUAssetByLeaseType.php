<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/02/2019
 * Time: 12.09
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Model\LeaseType;
use App\Zen\Report\Generate\GetCurrencyForLease;
use Carbon\Carbon;

class RoUAssetByLeaseType extends GetCurrencyForLease
{

    function generateReport()
    {
        $reportStartDate = request() -> end_date;
        $differenceInMonths = request() -> number_of_month;

        $date = [];
        $total = [];
        $startDate = Carbon ::parse($reportStartDate) -> startOfMonth() -> toDateString();
        $endDate = Carbon ::parse($reportStartDate) -> endOfMonth() -> toDateString();

        $requestedLeaseType = request() -> get('lease_type_id');

        if($requestedLeaseType) {
            $leaseTypes = LeaseType ::whereIn('id', $requestedLeaseType) -> get();
        } else {
            $leaseTypes = LeaseType ::Has('leases') -> get();
        }
        foreach(range(1, $differenceInMonths) as $mon) {
            $dateShow = Carbon ::parse($endDate) -> format('Y - M');
            $date[] = $dateShow;

            $total['Depreciation']['Total'][$dateShow] = 0;
            $total['Additions To ROA']['Total'][$dateShow] = 0;
            $total['Decrease To ROA']['Total'][$dateShow] = 0;
            $total['Right of use asset amount']['Total'][$dateShow] = 0;

            foreach($leaseTypes as $leaseType) {
                $total['Depreciation'][$leaseType -> type][$dateShow] = 0;
                $total['Right of use asset amount'][$leaseType -> type][$dateShow] = 0;
                $total['Additions To ROA'][$leaseType -> type][$dateShow] = 0;
                $total['Decrease To ROA'][$leaseType -> type][$dateShow] = 0;

                request() -> merge(['lease_type_id' => $leaseType -> id]);
                $monthEndLeases = (new LeaseMonthValue()) -> getAllReportData($endDate);
                $changeLeases = (new LeaseChangeReport()) -> getLeaseChangeData($startDate, $endDate);

                foreach($monthEndLeases as $lease) {
                    $total['Depreciation'][$leaseType -> type][$dateShow] += rnd($lease -> monthly_depreciation_selected_currency);
                    $total['Right of use asset amount'][$leaseType -> type][$dateShow] += rnd($lease -> depreciation_closing_selected_currency);

                    $total['Right of use asset amount']['Total'][$dateShow] += rnd($lease -> depreciation_closing_selected_currency);
                    $total['Depreciation']['Total'][$dateShow] += rnd($lease -> monthly_depreciation_selected_currency);

                }


                foreach($changeLeases as $lease) {
                    $total['Additions To ROA'][$leaseType -> type][$dateShow] += rnd($lease -> depreciation_opening_balance_addition);
                    $total['Decrease To ROA'][$leaseType -> type][$dateShow] += rnd($lease -> depreciation_opening_balance_decrease);

                    $total['Additions To ROA']['Total'][$dateShow] += rnd($lease -> depreciation_opening_balance_addition);
                    $total['Decrease To ROA']['Total'][$dateShow] += rnd($lease -> depreciation_opening_balance_decrease);
                }

            }
            $startDate = Carbon ::parse($endDate) -> addDay() -> toDateString();
            $endDate = Carbon ::parse($endDate) -> addMonthNoOverflow() -> endOfMonth() -> toDateString();
        }
        request() -> merge(['lease_type_id' => $requestedLeaseType]);
        return array($total, $date);
    }

}