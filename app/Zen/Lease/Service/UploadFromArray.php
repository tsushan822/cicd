<?php


namespace App\Zen\Lease\Service;


use App\Zen\Lease\Calculate\Generate\GenerateLeaseFlow;
use App\Zen\Lease\Calculate\Generate\StoreGeneratedLeaseFlow;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

trait UploadFromArray
{
    private $portfolioName;
    private $costCenterName;
    private $counterpartyName;

    public function uploadIntoDatabase($collection)
    {
        $currencyIso4217 = Currency ::get() -> pluck('id', 'iso_4217_code') -> toArray();
        $this -> portfolioName = Portfolio ::get() -> pluck('id', 'name') -> toArray();
        $this -> counterpartyName = Counterparty ::counterparty() -> get() -> pluck('id', 'short_name') -> toArray();
        $entityName = Counterparty ::entity() -> get() -> pluck('id', 'short_name') -> toArray();
        $this -> costCenterName = Costcenter ::get() -> pluck('id', 'short_name') -> toArray();
        $leaseTypeName = LeaseType ::get() -> pluck('id', 'type') -> toArray();

        foreach($collection as $row) {
            $currencyId = $currencyIso4217[$row['currency']];
            $counterpartyId = $this -> checkAndCreateCounterparty($row, $currencyId);
            if(!$row['interest_rate_applied_for_the_lease'])
                $row['interest_rate_applied_for_the_lease'] = Counterparty ::findOrFail($entityName[$row['entity']]) -> lease_rate;
            $lease = Lease ::create([
                'entity_id' => $entityName[$row['entity']],
                'counterparty_id' => $counterpartyId,
                'customer_reference' => $row['customer_reference'],
                'lease_type_id' => $leaseTypeName[$row['leasetype']],
                'portfolio_id' => $this -> checkAndCreatePortfolio($row),
                'cost_center_id' => $this -> checkAndCreateCostCenter($row),
                'lease_rate' => $row['interest_rate_applied_for_the_lease'],
                'lease_amount' => $row['fixed_asset_lease_amount'],
                'lease_service_cost' => $row['services_included_in_lease'],
                'total_lease' => $row['services_included_in_lease'] + $row['fixed_asset_lease_amount'],
                'currency_id' => $currencyId,
                'effective_date' => Date ::excelToDateTimeObject($row['lease_start_date_yyyy_mm_dd']),
                'maturity_date' => Date ::excelToDateTimeObject($row['lease_end_date_yyyy_mm_dd']),
                'contractual_end_date' => $row['contractual_end_date_yyyy_mm_dd'] != null ? Date ::excelToDateTimeObject($row['contractual_end_date_yyyy_mm_dd']) : Date ::excelToDateTimeObject($row['lease_end_date_yyyy_mm_dd']),
                'first_payment_date' => Date ::excelToDateTimeObject($row['first_payment_date_yyyy_mm_dd']),
                'payment_day' => $row['future_payment_dates_within_a_month'],
                'lease_flow_per_year' => $row['payments_per_year'],
                'exercise_price' => $row['excersice_price_of_a_purchase_option'],
                'residual_value_guarantee' => $row['residual_value_guarantee'],
                'penalties_for_terminating' => $row['penalties_for_terminating_the_lease'],
                'payment_before_commencement_date' => $row['lease_payments_made_on_or_before_commencement_date'],
                'initial_direct_cost' => $row['initial_direct_cost'],
                'cost_dismantling_restoring_asset' => $row['estimated_cost_for_dismantling_restoring_asset'],
                'lease_incentives_received' => $row['lease_incentives_received'],
                'residual_value' => $row['residual_value'],
                'internal_order' => $row['internal_order'],
                'tax' => $row['tax'],
                'rou_asset_number' => $row['rou_asset_number'],
                'source' => 'Excel'
            ]);
            $paymentsTime = (new GenerateLeaseFlow()) -> setLease($lease) -> addFromExcel();
            (new StoreGeneratedLeaseFlow($lease)) -> storeLeaseFlows($paymentsTime, $lease -> lease_amount, $lease -> lease_service_cost, $lease -> effective_date);
        }
    }

    /**
     * @param $row
     * @return int | null
     */
    private function checkAndCreateCostCenter(object $row)
    {
        if(!$row['cost_center'])
            return null;

        if(array_key_exists($row['cost_center'], $this -> costCenterName))
            return $this -> costCenterName[$row['cost_center']];

        $newCostCenter = CostCenter ::create(['short_name' => $row['cost_center'], 'long_name' => $row['cost_center'], 'source' => 'Excel']);
        $this -> costCenterName[$newCostCenter -> short_name] = $newCostCenter -> id;
        return $newCostCenter -> id;
    }


    /**
     * @param $row
     * @return int
     */
    private function checkAndCreatePortfolio(object $row): int
    {
        if(array_key_exists($row['portfolio'], $this -> portfolioName))
            return $this -> portfolioName[$row['portfolio']];
        $newPortfolio = Portfolio ::create(['name' => $row['portfolio'], 'long_name' => $row['portfolio'], 'source' => 'Excel']);
        $this -> portfolioName[$newPortfolio -> name] = $newPortfolio -> id;
        return $newPortfolio -> id;
    }

    private function checkAndCreateCounterparty(object $row, int $currencyId): int
    {

        if(array_key_exists($row['counterparty'], $this -> counterpartyName))
            return $this -> counterpartyName[$row['counterparty']];
        $newCompany = Counterparty ::create(
            [
                'short_name' => $row['counterparty'],
                'long_name' => $row['counterparty'],
                'currency_id' => $currencyId,
                'is_counterparty' => 1,
                'is_entity' => 0,
                'is_external' => 0,
                'source' => 'Excel'
            ]
        );
        $this -> counterpartyName[$newCompany -> short_name] = $newCompany -> id;
        return $newCompany -> id;
    }
}