<?php

namespace Tests\Browser;

use App\Zen\Setting\Model\CostCenter;
use App\Zen\User\Model\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateCostCenterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateCostCenter()
    {
        $user = User ::find(1);
        $costCenterName = 'Test Cost Center-' . strtotime(now());
        $this -> browse(function ($first) use ($user, $costCenterName) {
            $first -> loginAs($user) -> visit('/costcenters/create')
                -> type('short_name', $costCenterName)
                -> type('long_name', 'Test Cost Center Description')
                -> press('#register_submit')
                -> assertSee('Cost centers');
        });

        $firstCreated = CostCenter ::orderBy('id', 'desc') -> first();
        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/costcenters/' . ($firstCreated -> id) . '/edit')
                -> assertSee('Cost center (' . $firstCreated -> short_name . ')')
                -> pause(100)
                -> press('#register_submit')
                -> assertSee('Updated!');
        });

        $this -> browse(function ($first) use ($user, $firstCreated) {
            $costCenterNameCopy = 'TCC-' . strtotime(now());
            $first -> loginAs($user) -> visit('/costcenters/copy/' . ($firstCreated -> id))
                -> pause(100)
                -> assertSee('Cost center (' . $firstCreated -> short_name . ')')
                -> type('short_name', $costCenterNameCopy)
                -> type('long_name', 'TestCostCenter')
                -> press('#register_submit')
                -> assertSee('Cost centers');
        });

        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/costcenters/' . ($firstCreated -> id))
                -> assertSee('Delete ' . $firstCreated -> id)
                -> press('#register_submit')
                -> pause(100)
                -> assertSee('Cost Center Deleted');

        });

    }
}
