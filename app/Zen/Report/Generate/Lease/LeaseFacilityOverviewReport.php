<?php


namespace App\Zen\Report\Generate\Lease;


use App\Zen\Lease\Model\Lease;
use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Model\AuditTrail;
use Carbon\Carbon;

class LeaseFacilityOverviewReport extends GetCurrencyForLease
{

    function generateReport()
    {
        $startDate = request() -> input('end_date') ?: today() -> toDateString();
        $leases = Lease ::reportable() -> where('show_agreement_in_report', 1) -> where('maturity_date', '>', $startDate) -> get();
        foreach($leases as $lease) {

            $auditTrail = AuditTrail ::where(['model' => 'Lease', 'event' => 'updated', 'table_id' => $lease -> id]) -> where('after', 'like', '%number_of_employees%') -> orderBy('created_at', 'desc') -> first();
            $lease -> employees_last_updated = $auditTrail instanceof AuditTrail ? Carbon ::parse($auditTrail -> created_at) -> toDateString() : Carbon ::parse($lease -> created_at) -> toDateString();

            $auditTrail = AuditTrail ::where(['model' => 'Lease', 'event' => 'updated', 'table_id' => $lease -> id]) -> where('after', 'like', '%number_of_workstations%') -> orderBy('created_at', 'desc') -> first();
            $lease -> workstations_last_updated = $auditTrail instanceof AuditTrail ? Carbon ::parse($auditTrail -> created_at) -> toDateString() : Carbon ::parse($lease -> created_at) -> toDateString();

            if(request() -> input('currency_id') && request() -> input('currency_id') != $lease -> currency_id) {
                $lease -> total_lease_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> total_lease, $startDate);
                $lease -> capital_rent_per_month_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> capital_rent_per_month, $startDate);
                $lease -> maintenance_rent_per_month_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> maintenance_rent_per_month, $startDate);
                $lease -> parking_cost_per_month_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> parking_cost_per_month, $startDate);
                $lease -> rent_security_deposit_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> rent_security_deposit, $startDate);
                $lease -> other_cost_per_month_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> other_cost_per_month, $startDate);
            } else {
                $lease -> total_lease_base_currency = $lease -> total_lease;
                $lease -> capital_rent_per_month_base_currency = $lease -> capital_rent_per_month;
                $lease -> maintenance_rent_per_month_base_currency = $lease -> maintenance_rent_per_month;
                $lease -> parking_cost_per_month_base_currency = $lease -> parking_cost_per_month;
                $lease -> rent_security_deposit_base_currency = $lease -> rent_security_deposit;
                $lease -> other_cost_per_month_base_currency = $lease -> other_cost_per_month;
            }
        }

        return array($startDate, $leases);
    }
}