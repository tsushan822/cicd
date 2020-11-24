<?php

namespace Tests\Browser;

use App\Zen\User\Model\User;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;

class CreateUserTest extends DuskTestCase
{

    public function test_create_user_duplicate()
    {
        $this -> browse(function ($first) {

            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/users/create')
                -> type('#name', 'Trial')
                -> type('email', 'trial@zentreasury.com')
                -> press('#register_submit')
                -> assertSee('The email has already been taken.');;
        });
    }

    public function test_create_user_third_party_domain()
    {
        $this -> browse(function ($first) {

            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/users/create')
                -> type('#name', 'Trial')
                -> type('email', 'trial@zentreasury.test')
                -> press('#register_submit')
                -> assertSee('third party email domain is not valid. Please contact support@leaseaccounting.app in case you need to add additional domains into your');;
        });
    }

    public function test_create_user_empty()
    {
        $this -> browse(function ($first) {

            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/users/create')
                -> press('#register_submit')
                -> assertSee('The name field is required.');
        });
    }

    public function test_create_user()
    {
        $email = 'test' . strtotime(now() -> toDateString()) . '@zentreasury.com';
        $this -> browse(function ($first) use ($email) {

            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/users/create')
                -> type('#name', 'Test')
                -> type('email', $email)
                -> select('role_id', ['2', '3'])
                -> select('counterparty_id', ['2', '3'])
                -> press('#register_submit')
                -> assertSee('The user has been invited by email');;
        });

        $user = DB ::table('users') -> connection('system') -> where('email', $email) -> delete();
        $userDelete = User::where('email',$email)->delete();
    }

}
