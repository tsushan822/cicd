<?php

namespace App\Jobs\Leases;

use App\Zen\Lease\Calculate\Generate\GenerateLeaseFlow;
use App\Zen\Lease\Calculate\Generate\StoreGeneratedLeaseFlow;
use App\Zen\Lease\Calculate\Request\LeaseExtensionRequest;
use App\Zen\Lease\Model\Lease;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddDemoLeasesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var int
     */
    public $website_id;

    /**
     * Create a new job instance.
     *
     * @param int $website_id
     */
    public function __construct(int $website_id)
    {
        $this -> website_id = $website_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $leaseArray = [
            //1
            [
                'entity_id' => 2,
                'counterparty_id' => 1,//Counterparty ::whereNot('is_parent_company', 1) -> counterparty -> first() -> short_name,
                'customer_reference' => 'Example 1',
                'currency_id' => 2,
                'lease_type_id' => 1,
                'lease_rate' => 8,
                'portfolio_id' => 1,
                'ifrs_accounting' => 1,
                'lease_amount' => 100000,
                'lease_service_cost' => 0,
                'total_lease' => 100000,
                'effective_date' => '2018-01-01',
                'maturity_date' => '2023-12-31',
                'payment_day' => 1,
                'first_payment_date' => '2019-01-31',
                'lease_flow_per_year' => 1,
                'payment_before_commencement_date' => 100000,
                'source' => 'Seeder'
            ],
            //2
            [
                'entity_id' => 2,
                'counterparty_id' => 1,//Counterparty ::whereNot('is_parent_company', 1) -> counterparty -> first() -> short_name,
                'currency_id' => 2,
                'lease_type_id' => 1,
                'lease_rate' => 8,
                'portfolio_id' => 1,
                'lease_amount' => 40000,
                'lease_service_cost' => 0,
                'ifrs_accounting' => 1,
                'total_lease' => 40000,
                'effective_date' => '2018-01-01',
                'maturity_date' => '2021-12-31',
                'payment_day' => 1,
                'first_payment_date' => '2018-04-30',
                'lease_flow_per_year' => 4,
                'payment_before_commencement_date' => 40000,
                'customer_reference' => 'Example 2',
                'source' => 'Seeder',
                'price_increase_percent' => 5.00,
                'price_increase_interval' => 12,
                'date_of_first_increase' => '2018-10-01',
            ],
            //3
            [
                'entity_id' => 2,
                'counterparty_id' => 1,//Counterparty ::whereNot('is_parent_company', 1) -> counterparty -> first() -> short_name,
                'currency_id' => 2,
                'lease_type_id' => 1,
                'lease_rate' => 8,
                'portfolio_id' => 1,
                'lease_amount' => 2000,
                'ifrs_accounting' => 1,
                'lease_service_cost' => 0,
                'total_lease' => 2000,
                'effective_date' => '2019-01-01',
                'maturity_date' => '2025-03-31',
                'payment_day' => 1,
                'first_payment_date' => '2019-01-31',
                'lease_flow_per_year' => 12,
                'payment_before_commencement_date' => 0,
                'customer_reference' => 'Example 3',
                'source' => 'Seeder',
                'extension' => [
                    'date_of_change' => '2020-01-01',
                    'extension_start_date' => '2020-01-01',
                    'extension_end_date' => '2025-03-31',
                    'extension_period_amount' => 2200.00,
                    'extension_service_cost' => 0.00,
                    'extension_total_cost' => 2200.00,
                    'lease_extension_rate' => '8.00',
                    'lease_extension_type' => 'Increase In Scope'
                ]
            ],
            //4
            [
                'entity_id' => 2,
                'counterparty_id' => 1,//Counterparty ::whereNot('is_parent_company', 1) -> counterparty -> first() -> short_name,
                'currency_id' => 2,
                'lease_type_id' => 2,
                'lease_rate' => 8,
                'ifrs_accounting' => 1,
                'portfolio_id' => 1,
                'lease_amount' => 25000,
                'lease_service_cost' => 0,
                'total_lease' => 25000,
                'effective_date' => '2019-01-01',
                'maturity_date' => '2022-12-31',
                'payment_day' => 31,
                'first_payment_date' => '2019-03-31',
                'lease_flow_per_year' => 4,
                'payment_before_commencement_date' => 0,
                'customer_reference' => 'Example 4',
                'source' => 'Seeder',
                'extension' => [
                    'date_of_change' => '2020-07-01',
                    'extension_start_date' => '2020-07-01',
                    'extension_end_date' => '2022-12-31',
                    'extension_period_amount' => 15000.00,
                    'extension_service_cost' => 0.00,
                    'extension_total_cost' => 15000.00,
                    'lease_extension_rate' => '8.00',
                    'lease_extension_type' => 'Decrease In Scope',
                    'decrease_in_scope_rate' => 50,
                ]
            ],
            //5
            [
                'entity_id' => 2,
                'counterparty_id' => 1,//Counterparty ::whereNot('is_parent_company', 1) -> counterparty -> first() -> short_name,
                'currency_id' => 2,
                'lease_type_id' => 3,
                'lease_rate' => 8,
                'portfolio_id' => 1,
                'ifrs_accounting' => 1,
                'lease_amount' => 4000,
                'lease_service_cost' => 0,
                'total_lease' => 4000,
                'effective_date' => '2019-01-01',
                'maturity_date' => '2024-04-30',
                'payment_day' => 31,
                'first_payment_date' => '2019-01-31',
                'lease_flow_per_year' => 12,
                'payment_before_commencement_date' => 0,
                'customer_reference' => 'Example 5',
                'source' => 'Seeder',
                'extension' => [
                    'date_of_change' => '2020-01-01',
                    'extension_start_date' => '2020-01-01',
                    'extension_end_date' => '2024-04-30',
                    'extension_period_amount' => 4000.00,
                    'extension_service_cost' => 0.00,
                    'extension_total_cost' => 4000.00,
                    'lease_extension_rate' => '8.00',
                    'lease_extension_type' => 'Increase In Scope',
                    'payment_month' => [
                        1 => '2020-01-31',
                        2 => '2020-02-29',
                        3 => '2020-03-31',
                    ],
                    'payment_value' => [
                        1 => 0.0,
                        2 => 0.0,
                        3 => 0.0,
                    ],
                    'payment_service_cost' => [
                        1 => 0.0,
                        2 => 0.0,
                        3 => 0.0,
                    ]
                ]
            ],
        ];
        foreach($leaseArray as $data) {
            $lease = Lease ::create($data);
            if(isset($data['price_increase_percent'])) {
                $paymentsTime = (new GenerateLeaseFlow()) -> setLease($lease) -> addFromExcel($data['price_increase_percent'], $data['price_increase_interval'], $data['date_of_first_increase']);
            } else {
                $paymentsTime = (new GenerateLeaseFlow()) -> setLease($lease) -> addFromExcel();
            }
            (new StoreGeneratedLeaseFlow($lease)) -> storeLeaseFlows($paymentsTime, $lease -> lease_amount, $lease -> lease_service_cost, $lease -> effective_date);
            if(isset($data['extension'])) {
                $data['extension']['lease_id'] = $lease -> id;
                request() -> merge($data['extension']);
                LeaseExtensionRequest ::leaseExtension(\request(), $lease);
            }
        }
    }
}
