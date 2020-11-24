<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this -> browse(function (Browser $browser) {
            $browser -> visit('/')
                -> pause(10)
                -> assertSee('Welcome to Leaseaccounting!');
        });

        $this -> browse(function (Browser $browser) {
            $browser -> visit('http://app.leaseaccounting.test/login/initial')
                -> assertSee('Welcome to Leaseaccounting!');
        });
    }
}
