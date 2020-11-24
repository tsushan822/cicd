<?php

namespace Tests\Browser;

use App\Zen\Setting\Model\FxRate;
use App\Zen\User\Model\User;
use Tests\DuskTestCase;

class ForeignExchangeRatesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateForeignExchangeRates()
    {
        $user = User ::find(1);
        FxRate :: where('id','<>',100) -> delete();
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/fxrates/create')
                -> select('ccy_base_id', 1)
                -> select('ccy_cross_id', 2)
                -> type('rate_bid', '0.005000')
                -> type('date', today() -> toDateString())
                -> press('#register_submit')
                -> pause(500)
                -> assertSee('Success!');
        });

        $firstCreated = FxRate ::orderBy('id', 'desc') -> first();
        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/fxrates/' . ($firstCreated -> id) . '/edit')
                -> pause(500)
                -> assertSee('FX Rate details')
                -> select('ccy_base_id', 1)
                -> select('ccy_cross_id', 2)
                -> type('rate_bid', '0.015000')
                -> type('date', today() -> subDay() -> toDateString())
                -> press('#register_submit')
                -> pause(500)
                -> assertSee('Success!');
        });

        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/fxrates/copy/' . ($firstCreated -> id))
                -> pause(100)
                -> assertSee('FX Rate details')
                -> select('ccy_base_id', 1)
                -> select('ccy_cross_id', 2)
                -> type('rate_bid', '0.017000')
                -> type('date', today() -> subDay() -> toDateString())
                -> press('#register_submit')
                -> assertSee('The date, currency base and currency cross should be unique. Similar data already exists.')
                -> visit('/fxrates/copy/' . ($firstCreated -> id))
                -> pause(100)
                -> assertSee('FX Rate details')
                -> select('ccy_base_id', 1)
                -> select('ccy_cross_id', 2)
                -> type('rate_bid', '0.017000')
                -> type('date', today() -> subDays(2) -> toDateString())
                -> press('#register_submit')
                -> pause(100)
                -> assertSee('Success!');
        });


        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/fxrates/' . ($firstCreated -> id))
                -> assertSee('Delete ' . $firstCreated -> id)
                -> press('#register_submit')
                -> pause(300)
                -> assertSee('Deleted');

        });

    }
}
