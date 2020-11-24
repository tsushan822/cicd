<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class LeaseAdditionRoUAssetTest extends DuskTestCase
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
            $first -> loginAs($user) -> visit('/reporting/additions-right-asset')
                -> keys('#end_date', '2019-09-30')
                -> type('#lease_id', $firstCreated)
                -> press('submit')
                -> assertSeeIn('.cur', 'EUR')
                -> assertSeeIn('.payment_before_commencement_date', '500.00')
                -> assertDontSeeIn('.payment_before_commencement_date', '-500.00')
                -> assertSeeIn('.payment_before_commencement_date_base_currency', '500.00')
                -> assertDontSeeIn('.payment_before_commencement_date_base_currency', '-500.00')
                -> assertSeeIn('.initial_direct_cost', '500.00')
                -> assertDontSeeIn('.initial_direct_cost', '-500.00')
                -> assertSeeIn('.initial_direct_cost_base_currency', '500.00')
                -> assertDontSeeIn('.initial_direct_cost_base_currency', '-500.00')
                -> assertSeeIn('.cost_dismantling_restoring_asset', '500.00')
                -> assertDontSeeIn('.cost_dismantling_restoring_asset', '-500.00')
                -> assertSeeIn('.cost_dismantling_restoring_asset_base_currency', '500.00')
                -> assertDontSeeIn('.cost_dismantling_restoring_asset_base_currency', '-500.00')
                -> assertSeeIn('.lease_incentives_received', '500.00')
                -> assertDontSeeIn('.lease_incentives_received', '-500.00')
                -> assertSeeIn('.lease_incentives_received_base_currency', '500.00')
                -> assertDontSeeIn('.lease_incentives_received_base_currency', '-500.00')
                -> assertSeeIn('.residual_value', '500.00')
                -> assertDontSeeIn('.residual_value', '-500.00')
                -> assertSeeIn('.residual_value_base_currency', '500.00')
                -> assertDontSeeIn('.residual_value_base_currency', '-500.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });
    }
}
