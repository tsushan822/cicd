<?php

namespace Tests\Browser;

use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Model\Counterparty;
use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class CreateCompanyTest extends DuskTestCase
{

    /**
     * @return void
     */
    public function testCreateCompany()
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/counterparties/create')
                -> type('short_name', 'B A')
                -> type('long_name', 'Banke Academy')
                -> select('currency_id', 2)
                -> check('is_counterparty')
                -> press('#register_submit')
                -> assertSee('Companies ');

        });

        $firstCreated = Counterparty ::orderBy('id','desc')->first();
        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/counterparties/' . ($firstCreated->id) . '/edit')
                -> assertSee('Company ('. $firstCreated->short_name. ')')
                -> type('short_name', 'Test')
                -> type('long_name', 'Test Company')
                -> select('currency_id', 2)
                -> check('is_counterparty')
                -> press('#register_submit')
                -> assertSee('Company updated');
        });



        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/counterparties/copy/' . ($firstCreated->id))
                -> pause(100)
                -> assertSee('Company (' . $firstCreated->short_name.')')
                -> type('short_name', 'Test Comp')
                -> type('long_name', 'Test related Company ')
                -> select('currency_id', 2)
                -> check('is_counterparty')
                -> press('#register_submit')
                -> assertSee('Company Saved!');
        });


        $this -> browse(function ($first) use ($user, $firstCreated) {
            $first -> loginAs($user) -> visit('/counterparties/' . ($firstCreated->id))
                -> assertSee('Delete ' . $firstCreated->id)
                -> press('#register_submit')
                -> assertSee('Company Deleted');

        });


    }

}
