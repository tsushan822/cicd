<?php

namespace Tests\Browser;

use App\Zen\Setting\Model\Portfolio;
use App\Zen\User\Model\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreatePortfolioTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_create_portfolio()
    {

        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $portfolioName = 'Test Portfolio-'.strtotime(now());
            $first -> loginAs($user) -> visit('/portfolios/create')
                -> type('name', $portfolioName)
                -> type('long_name', 'Test Description')
                -> press('#register_submit')
                -> assertSee('Portfolio');
        });

        $firstCreated = Portfolio ::orderBy('id','desc')->first();
        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/portfolios/' . ($firstCreated->id) . '/edit')
                -> assertSee('Portfolio ('. $firstCreated->name. ')')
                -> type('name', 'Test P')
                -> type('long_name', 'Test Portfolio')
                -> press('#register_submit')
                -> assertSee('Portfolio updated!');
        });



        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/portfolios/copy/' . ($firstCreated->id))
                -> assertSee('Portfolio (Test P)')
                -> type('name', 'Test portfolio')
                -> type('long_name', 'Test related Portfolio')
                -> pause(100)
                -> press('#register_submit')
                -> assertSee('Portfolio');
        });

        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/portfolios/' . ($firstCreated->id))
                -> assertSee('Delete ' . $firstCreated->id)
                -> press('#register_submit')
                -> pause(200)
                -> assertSee('Portfolio deleted!');

        });
    }
}
