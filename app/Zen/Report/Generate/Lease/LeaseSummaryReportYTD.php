<?php


namespace App\Zen\Report\Generate\Lease;


use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Model\Counterparty;
use Carbon\Carbon;

class LeaseSummaryReportYTD extends GetCurrencyForLease
{

    function generateReport()
    {
        $reportStartDate = Carbon ::parse(request() -> start_date) -> startOfMonth() -> toDateString();

        $reportEndDate = Carbon ::parse(request() -> end_date) -> endOfMonth() -> toDateString();

        $differenceInMonths = round(Carbon ::parse($reportStartDate) -> diffInDays(Carbon ::parse($reportEndDate)) / 30.42);

        $header = [];
        $total = [];
        $requestedEntity = request() -> get('entity_id');

        if($requestedEntity) {
            $entities = Counterparty ::whereIn('id', $requestedEntity) -> get();
        } else {
            $entities = Counterparty ::has('leases') -> allowedEntity() -> get();
        }


        foreach($entities as $entity) {
            $startDate = $reportStartDate;
            $endDate = Carbon ::parse($reportStartDate) -> endOfMonth() -> toDateString();

            $header[] = $entity -> short_name;

            $total['Fixed Amount'][$entity -> short_name] = 0;
            $total['Service Cost'][$entity -> short_name] = 0;
            $total['Total Lease Cost'][$entity -> short_name] = 0;
            $total['Depreciation'][$entity -> short_name] = 0;
            $total['Interest Cost'][$entity -> short_name] = 0;
            $total['Accrued Interest'][$entity -> short_name] = 0;
            $total['Realised Difference From Change'][$entity -> short_name] = 0;
            $total['Realised Fx Difference'][$entity -> short_name] = 0;
            $total['Unrealised Fx Difference'][$entity -> short_name] = 0;

            $total['Additions To Liability'][$entity -> short_name] = 0;
            $total['Decrease To Liability'][$entity -> short_name] = 0;
            $total['Additions To RoU Asset'][$entity -> short_name] = 0;
            $total['Decrease To RoU Asset'][$entity -> short_name] = 0;
            $total['Repayment of Loan'][$entity -> short_name] = 0;
            $total['Lease payment at start date'][$entity -> short_name] = 0;

            $total['Right of use asset amount'][$entity -> short_name] = 0;
            $total['Short Term liability'][$entity -> short_name] = 0;
            $total['Long Term liability'][$entity -> short_name] = 0;
            $total['Total liability'][$entity -> short_name] = 0;

            request() -> merge(['entity_id' => $entity -> id]);
            foreach(range(1, $differenceInMonths) as $mon) {

                $depreciation = 0;
                $repayment = 0;
                $interestCost = 0;
                $serviceCost = 0;
                $fixedAmount = 0;
                $totalLeaseCost = 0;
                $realisedFxDifference = 0;
                $realisedDifferenceFromChange = 0;
                $additionsToLiability = 0;
                $decreaseToLiability = 0;
                $additionsToROA = 0;
                $decreaseToROA = 0;
                $paymentStartDate = 0;


                $monthEndLeases = (new LeaseMonthValue()) -> getOnlyDepreciation($endDate);
                $changeLeases = (new LeaseChangeReport()) -> getLeaseChangeData($startDate, $endDate);
                $leaseFlows = (new LeasePaymentReport()) -> getLeaseMonthData($startDate, $endDate);


                foreach($monthEndLeases as $lease) {
                    $depreciation += rnd($lease -> monthly_depreciation_selected_currency);
                }

                foreach($leaseFlows as $leaseFlow) {
                    $repayment += rnd($leaseFlow -> repayment_base_currency);
                    $interestCost += rnd($leaseFlow -> interest_cost_base_currency);
                    $serviceCost += rnd($leaseFlow -> fees_base_currency);
                    $fixedAmount += rnd($leaseFlow -> fixed_payment_base_currency);
                    $totalLeaseCost += rnd($leaseFlow -> total_base_currency);
                    $realisedFxDifference += rnd($leaseFlow -> realised_fx_difference);
                }

                foreach($changeLeases as $lease) {
                    $realisedDifferenceFromChange += rnd($lease -> realised_difference_base_currency);
                    $additionsToLiability += rnd($lease -> liability_opening_balance_addition);
                    $decreaseToLiability += rnd($lease -> liability_opening_balance_decrease);
                    $additionsToROA += rnd($lease -> depreciation_opening_balance_addition);
                    $decreaseToROA += rnd($lease -> depreciation_opening_balance_decrease);
                    $realisedFxDifference += rnd($lease -> realised_fx_difference);
                    $paymentStartDate += isset($lease -> lease_payment_start_date_base_currency) ? rnd($lease -> lease_payment_start_date_base_currency) : 0;

                }

                $total['Depreciation'][$entity -> short_name] += $depreciation;
                $total['Repayment of Loan'][$entity -> short_name] += $repayment;
                $total['Lease payment at start date'][$entity -> short_name] += $paymentStartDate;
                $total['Interest Cost'][$entity -> short_name] += $interestCost;
                $total['Realised Fx Difference'][$entity -> short_name] += $realisedFxDifference;
                $total['Service Cost'][$entity -> short_name] += $serviceCost;
                $total['Fixed Amount'][$entity -> short_name] += $fixedAmount;
                $total['Total Lease Cost'][$entity -> short_name] += $totalLeaseCost;
                $total['Realised Difference From Change'][$entity -> short_name] += $realisedDifferenceFromChange;
                $total['Additions To Liability'][$entity -> short_name] += $additionsToLiability;
                $total['Decrease To Liability'][$entity -> short_name] += $decreaseToLiability;
                $total['Additions To RoU Asset'][$entity -> short_name] += $additionsToROA;
                $total['Decrease To RoU Asset'][$entity -> short_name] += $decreaseToROA;

                $startDate = Carbon ::parse($endDate) -> addDay() -> toDateString();
                $endDate = Carbon ::parse($endDate) -> addMonthNoOverflow() -> endOfMonth() -> toDateString();
            }

            $monthEndLeases = (new LeaseMonthValue()) -> getAllReportData(Carbon ::parse($reportEndDate) -> toDateString());

            foreach($monthEndLeases as $lease) {
                $total['Accrued Interest'][$entity -> short_name] += rnd($lease -> accrued_interest_base_currency);
                $total['Right of use asset amount'][$entity -> short_name] += rnd($lease -> depreciation_closing_selected_currency);
                $total['Unrealised Fx Difference'][$entity -> short_name] += rnd($lease -> total_liability_variation);
                $total['Short Term liability'][$entity -> short_name] += rnd($lease -> short_term_liability_base_currency);
                $total['Long Term liability'][$entity -> short_name] += rnd($lease -> long_term_liability_base_currency);
                $total['Total liability'][$entity -> short_name] += rnd($lease -> total_liability_base_currency);
            }
        }

        request() -> merge(['entity_id' => $requestedEntity]);
        return array($total, $header);
    }
}