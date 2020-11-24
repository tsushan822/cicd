<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/02/2019
 * Time: 12.09
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Report\Generate\GetCurrencyForLease;
use Carbon\Carbon;

class LeaseSummaryReport extends GetCurrencyForLease
{

    function generateReport()
    {
        $reportStartDate = request() -> end_date;
        $differenceInMonths = request() -> number_of_month;

        $date = [];
        $total = [];
        $startDate = Carbon ::parse($reportStartDate) -> startOfMonth() -> toDateString();
        $endDate = Carbon ::parse($reportStartDate) -> endOfMonth() -> toDateString();
        foreach(range(1, $differenceInMonths) as $mon) {
            $dateShow = Carbon ::parse($endDate) -> format('Y - M');
            $date[] = $dateShow;
            $total[$dateShow]['Fixed Amount'] = 0;
            $total[$dateShow]['Service Cost'] = 0;
            $total[$dateShow]['Total Lease Cost'] = 0;
            $total[$dateShow]['Depreciation'] = 0;
            $total[$dateShow]['Interest Cost'] = 0;
            $total[$dateShow]['Accrued Interest'] = 0;
            $total[$dateShow]['Realised Difference From Change'] = 0;
            $total[$dateShow]['Realised Fx Difference'] = 0;
            $total[$dateShow]['Unrealised Fx Difference'] = 0;

            $total[$dateShow]['Additions To Liability'] = 0;
            $total[$dateShow]['Decrease To Liability'] = 0;
            $total[$dateShow]['Additions To ROA'] = 0;
            $total[$dateShow]['Decrease To ROA'] = 0;
            $total[$dateShow]['Repayment of Loan'] = 0;
            $total[$dateShow]['Lease payment at start date'] = 0;

            $total[$dateShow]['Right of use asset amount'] = 0;
            $total[$dateShow]['Short Term liability'] = 0;
            $total[$dateShow]['Long Term liability'] = 0;
            $total[$dateShow]['Total liability'] = 0;


            $monthEndLeases = (new LeaseMonthValue()) -> getAllReportData($endDate);
            $changeLeases = (new LeaseChangeReport()) -> getLeaseChangeData($startDate, $endDate);
            $leaseFlows = (new LeasePaymentReport()) -> getLeaseMonthData($startDate, $endDate);


            foreach($monthEndLeases as $lease) {
                $total[$dateShow]['Accrued Interest'] += rnd($lease -> accrued_interest_base_currency);
                $total[$dateShow]['Right of use asset amount'] += rnd($lease -> depreciation_closing_selected_currency);
                $total[$dateShow]['Depreciation'] += rnd($lease -> monthly_depreciation_selected_currency);
                $total[$dateShow]['Unrealised Fx Difference'] += rnd($lease -> total_liability_variation);
                $total[$dateShow]['Short Term liability'] += rnd($lease -> short_term_liability_base_currency);
                $total[$dateShow]['Long Term liability'] += rnd($lease -> long_term_liability_base_currency);
                $total[$dateShow]['Total liability'] += rnd($lease -> total_liability_base_currency);
            }

            foreach($leaseFlows as $leaseFlow) {
                $total[$dateShow]['Repayment of Loan'] += rnd($leaseFlow -> repayment_base_currency);
                $total[$dateShow]['Interest Cost'] += rnd($leaseFlow -> interest_cost_base_currency);
                $total[$dateShow]['Realised Fx Difference'] += rnd($leaseFlow -> realised_fx_difference);
                $total[$dateShow]['Service Cost'] += rnd($leaseFlow -> fees_base_currency);
                $total[$dateShow]['Fixed Amount'] += rnd($leaseFlow -> fixed_payment_base_currency);
                $total[$dateShow]['Total Lease Cost'] += rnd($leaseFlow -> total_base_currency);
            }

            foreach($changeLeases as $lease) {
                $total[$dateShow]['Realised Difference From Change'] += rnd($lease -> realised_difference_base_currency);
                $total[$dateShow]['Additions To Liability'] += rnd($lease -> liability_opening_balance_addition);
                $total[$dateShow]['Decrease To Liability'] += rnd($lease -> liability_opening_balance_decrease);
                $total[$dateShow]['Additions To ROA'] += rnd($lease -> depreciation_opening_balance_addition);
                $total[$dateShow]['Decrease To ROA'] += rnd($lease -> depreciation_opening_balance_decrease);
                $total[$dateShow]['Realised Fx Difference'] += rnd($lease -> realised_fx_difference);
                $total[$dateShow]['Lease payment at start date'] += isset($lease -> lease_payment_start_date_base_currency) ? rnd($lease -> lease_payment_start_date_base_currency) : 0;
            }

            $startDate = Carbon ::parse($endDate) -> addDay() -> toDateString();
            $endDate = Carbon ::parse($endDate) -> addMonthNoOverflow() -> endOfMonth() -> toDateString();
        }
        return array($total, $date);
    }

}