<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class LeaseAdditionLiabilityTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @return void
     */
    public function testGtPage7To15()
    {
        $this -> browse(function ($first) {
            //First lease change report //id 336 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2023-12-31', 5, '2018-12-31',12,100);
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/additions-lease-liability')
                -> keys('#end_date', '2019-09-30')
                -> type('#lease_id', $firstCreated)
                -> press('submit')
                -> assertSeeIn('.cur', 'EUR')
                -> assertSeeIn('.exercise_price', '500.00')
                -> assertDontSeeIn('.exercise_price', '-500.00')
                -> assertSeeIn('.exercise_price_base_currency', '500.00')
                -> assertDontSeeIn('.exercise_price_base_currency', '-500.00')
                -> assertSeeIn('.residual_value_guarantee', '500.00')
                -> assertDontSeeIn('.residual_value_guarantee', '-500.00')
                -> assertSeeIn('.residual_value_guarantee_base_currency', '500.00')
                -> assertDontSeeIn('.residual_value_guarantee_base_currency', '-500.00')
                -> assertSeeIn('.penalties_for_terminating', '500.00')
                -> assertDontSeeIn('.penalties_for_terminating', '-500.00')
                -> assertSeeIn('.penalties_for_terminating_base_currency', '500.00')
                -> assertDontSeeIn('.penalties_for_terminating_base_currency', '-500.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });
    }
}
