<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Zen\User\Model\User;

class LeaseValuationReportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @return void
     */
    public function testGtPage1To6()
    {
        $this -> browse(function ($first) {
            //Seventh lease change report //id 37 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31' );
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-valuation')

                -> type('#lease_id', $firstCreated)
                -> keys('#end_date', '2018-05-31')
                -> press('submit')
                -> assertSeeIn('.cur', 'USD')
                -> assertSeeIn('.total_liability', '24,962.98')
                -> assertDontSeeIn('.total_liability', '-24,962.98')
                -> assertSeeIn('.total_liability_base_currency', '21,337.70')
                -> assertDontSeeIn('.total_liability_base_currency', '-21,337.70')
                -> assertSeeIn('.discount_instrument', '24,592.27')
                -> assertDontSeeIn('.discount_instrument', '-24,592.27')
                -> assertSeeIn('.discount_instrument_base_currency', '21,020.83')
                -> assertDontSeeIn('.discount_instrument_base_currency', '-21,020.83')
                -> assertSeeIn('.currency_valuation', '-1,335.73')
                -> assertSeeIn('.price_difference', '316.87')
                -> assertDontSeeIn('.price_difference', '-316.87')
                -> assertSeeIn('.total_valuation', '-1,018.86')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });
    }
}
