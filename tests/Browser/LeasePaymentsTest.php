<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class LeasePaymentsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @return void
     */
    /*public function testGtPage16To23()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/month-payment')
                -> type('#lease_id', '37')
                -> keys('#start_date', '2018-05-01')
                -> keys('#end_date', '2018-05-31')
                -> press('submit')
                -> assertSeeIn('.cur', 'USD')
                -> assertSeeIn('.total', '1,400.00')
                -> assertDontSeeIn('.total', '-1,400.00')
                -> assertSeeIn('.total_base_currency', '1,196.68')
                -> assertDontSeeIn('.total_base_currency', '-1,196.68')
                -> assertSeeIn('.fixed_payment', '1,400.00')
                -> assertDontSeeIn('.fixed_payment', '-1,400.00')
                -> assertSeeIn('.fixed_payment_base_currency', '1,196.68')
                -> assertDontSeeIn('.fixed_payment_base_currency', '-1,196.68')
                -> assertSeeIn('.fees', '0.00')
                -> assertSeeIn('.fees_base_currency', '0.00')
                -> assertSeeIn('.repayment', '1,231.46')
                -> assertDontSeeIn('.repayment', '-1,231.46')
                -> assertSeeIn('.repayment_base_currency', '1,052.62')
                -> assertDontSeeIn('.repayment_base_currency', '-1,052.62')
                -> assertSeeIn('.interest_cost', '168.54')
                -> assertDontSeeIn('.interest_cost', '-168.54')
                -> assertSeeIn('.interest_cost_base_currency', '144.06')
                -> assertDontSeeIn('.interest_cost_base_currency', '-144.06');

        });
    }*/


    /**
     * A Dusk test example.
     * @return void
     */
    public function testCostCenterSplit()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            //First lease change report //id 301 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2016-01-01', '2017-12-31', 8, '2016-01-31');
            $first -> loginAs($user) -> visit('/reporting/month-payment')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2017-05-01')
                -> keys('#end_date', '2017-06-30')
                -> press('submit')
                -> assertSeeIn('.cur', 'USD')
                -> assertSeeIn('.total', '500.00')
                -> assertDontSeeIn('.total', '-500.00')
                -> assertSeeIn('.total_base_currency', '400.00')
                -> assertDontSeeIn('.total_base_currency', '-400.00')
                -> assertSeeIn('.fixed_payment', '500.00')
                -> assertDontSeeIn('.fixed_payment', '-500.00')
                -> assertSeeIn('.fixed_payment_base_currency', '400.00')
                -> assertDontSeeIn('.fixed_payment_base_currency', '-400.00')
                -> assertSeeIn('.fees', '0.00')
                -> assertSeeIn('.fees_base_currency', '0.00')
                -> assertSeeIn('.repayment', '474.99')
                -> assertDontSeeIn('.repayment', '-474.99')
                -> assertSeeIn('.repayment_base_currency', '379.99')
                -> assertDontSeeIn('.repayment_base_currency', '-379.99')
                -> assertSeeIn('.interest_cost', '25.01')
                -> assertDontSeeIn('.interest_cost', '-25.01')
                -> assertSeeIn('.interest_cost_base_currency', '20.01')
                -> assertDontSeeIn('.interest_cost_base_currency', '-20.01')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });
    }
}
