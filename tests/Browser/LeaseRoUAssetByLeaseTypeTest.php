<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/03/2019
 * Time: 14.55
 */

namespace Tests\Browser;

use App\Zen\User\Model\User;
use Tests\DuskTestCase;

class LeaseRoUAssetByLeaseTypeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @return void
     */
    public function testGtPageRoUAssetPortfolio()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/rou-asset-lease-type')
                -> keys('#end_date', '2019-02-01')
                -> select('#currency_id', 1)
                -> select('#portfolio_id',7)
                -> press('submit')
                -> waitFor('#datatable-rou-asset_wrapper', 5)
                -> assertSeeIn('.depreciation-construction-hardware-2019-feb', '0.00')
                -> assertSeeIn('.depreciation-office-2019-feb', '2,719.63')
                -> assertSeeIn('.depreciation-it-equipment-2019-feb', '0.00')
                -> assertSeeIn('.depreciation-car-leasing-2019-feb', '923.87')
                -> assertSeeIn('.depreciation-total-2019-feb', '3,643.50')

                -> assertSeeIn('.additions-to-roa-construction-hardware-2019-feb', '0.00')
                -> assertSeeIn('.additions-to-roa-office-2019-feb', '0.00')
                -> assertSeeIn('.additions-to-roa-it-equipment-2019-feb', '0.00')
                -> assertSeeIn('.additions-to-roa-car-leasing-2019-feb', '0.00')
                -> assertSeeIn('.additions-to-roa-total-2019-feb', '0.00')

                -> assertSeeIn('.decrease-to-roa-construction-hardware-2019-feb', '0.00')
                -> assertSeeIn('.decrease-to-roa-office-2019-feb', '0.00')
                -> assertSeeIn('.decrease-to-roa-it-equipment-2019-feb', '0.00')
                -> assertSeeIn('.decrease-to-roa-car-leasing-2019-feb', '0.00')
                -> assertSeeIn('.decrease-to-roa-total-2019-feb', '0.00')

                -> assertSeeIn('.right-of-use-asset-amount-construction-hardware-2019-feb', '0.00')
                -> assertSeeIn('.right-of-use-asset-amount-office-2019-feb', '18,505.49')
                -> assertSeeIn('.right-of-use-asset-amount-it-equipment-2019-feb', '0.00')
                -> assertSeeIn('.right-of-use-asset-amount-car-leasing-2019-feb', '20,325.19')
                -> assertSeeIn('.right-of-use-asset-amount-total-2019-feb', '38,830.68');
        });
    }
}