<?php

namespace Tests\Browser;

use App\Zen\Lease\Model\Lease;
use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class CreateLeaseZTest extends DuskTestCase
{

    /**
     * @return void
     */
    public function est_create_lease()
    {
        $firstCreated = $this -> create_lease(1000, 1, '2016-01-01', '2017-12-31', 8, '2016-01-31');
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/leases/' . ($firstCreated) . '/edit')
                -> assertSee('Lease agreement ' . $firstCreated)
                -> press('#register_submit')
                -> assertSee('Lease agreement ' . $firstCreated);
        });

        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/leases/copy/' . ($firstCreated))
                -> pause(100)
                -> assertSee('Copy Lease agreement ' . $firstCreated)
                -> press('×')
                -> pause(100)
                -> press('#register_submit');
        });
        $maxLeaseId = Lease ::max('id');
        $this -> delete_lease($maxLeaseId);
    }


    public function est_create_lease_1()
    {
        //First lease test
        $this -> browse(function ($first) {
            $firstCreated = $this -> create_lease('100,000.00', 1, '2018-01-01', '2023-12-31', 8, '2019-01-31', 1);

            $this -> match_with_database($firstCreated, 1);

            $this -> delete_lease($firstCreated);
        });
    }


    //Add price increase in this test
    public function est_create_lease_2()
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/leases/create')
                -> select('#currency_id', '2')
                -> type('#lease_amount', '40,000.00')
                -> type('#lease_service_cost', '0.00')
                -> select('#entity_id', '2')
                -> select('#counterparty_id', '1')
                -> select('#lease_type_id', 1)
                -> select('#portfolio_id', 1)
                -> select('#cost_center_id', 1)
                -> select('#lease_flow_per_year', 4)
                -> type('#customer_reference', 'Some reference')
                -> type('#effective_date', '2018-01-01')
                -> type('#maturity_date', '2021-12-31')
                -> type('#first_payment_date', '2018-04-30')
                -> type('#lease_rate', 8)
                -> pause(500)
                -> press('#register_submit')
                -> assertSee('Payment schedule generator')
                -> type('#negotiate_price_increase_percent', 5)
                -> select('#price_increase_interval', 3)
                -> type('#date_of_first_price_increase', '2018-10-01')
                -> press('#register_submit')
                -> press('#register_submit')
                -> assertSee('Lease agreement');
        });
        $firstCreated = Lease ::max('id');
        $this -> match_with_database($firstCreated, 2);

        $this -> delete_lease($firstCreated);
    }

    public function test_create_test_3()
    {
        $firstCreated = $this -> create_lease('2000', 1, '2019-01-01', '2025-03-31', 8, '2019-01-31', 12);

        $this -> match_with_database_ext($firstCreated, 3);

        $this -> create_lease_extension('2200', $firstCreated);

        $this -> delete_lease($firstCreated);
    }

    public function est_create_test_4()
    {

        $firstCreated = $this -> create_lease('25,000.00', 2, '2019-01-01', '2022-12-31', 8, '2019-03-31', 4);

        $this -> match_with_database_ext($firstCreated, 4);

        $this -> delete_lease($firstCreated);

    }

    public function est_create_test_5()
    {
        $firstCreated = $this -> create_lease('4000', 3, '2019-01-01', '2024-04-30', 8, '2019-01-31', 12);

        $this -> match_with_database_ext($firstCreated, 5);

        $this -> delete_lease($firstCreated);
    }

}
