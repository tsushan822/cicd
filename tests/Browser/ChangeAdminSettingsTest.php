<?php

namespace Tests\Browser;


use App\Zen\User\Model\User;
use Tests\DuskTestCase;

class ChangeAdminSettingsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_change_admin_settings()
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/admin/settings')
                -> type('freezer_date', '2020-08-10')
                -> select('date_freezer_active', '0')
                -> type('min_password_length', '10')
                -> type('max_password_length', '18')
                -> check('enable_change_password')
                -> type('password_change_days', '65')
                -> check('enable_failed_login_lock')
                -> type('number_of_unsucessful_login', '6')
                -> check('auth_log')
                -> check('active_all_auth')
                -> check('enable_cost_center_split')
                -> check('one_capital')
                -> check('one_small')
                -> check('one_special')
                -> check('one_number')
                -> press('#submit')
                -> assertSee('Admin Settings');
        });
    }

    public function est_freeze_period()
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/admin/settings')
                -> type('freezer_date', '2020-08-31')
                -> select('date_freezer_active', '1')
                -> press('#submit')
                -> assertSee('Admin Settings')
                -> visit('/leases/copy/1')
                -> pause(100)
                -> assertSee('Copy Lease agreement ' . 1)
                -> press('×')
                -> pause(100)
                -> press('#register_submit')
                -> assertSee('You cannot create, modify or delete agreements where the start date is before or on this date 2020-08-31')
                -> visit('/admin/settings')
                -> select('date_freezer_active', '0')
                -> press('#submit')
                -> assertSee('Admin Settings');

        });
    }

    public function est_password_rule()
    {
        $user = User ::find(1);
        $this -> browse(function ($first) use ($user) {
            $first -> loginAs($user) -> visit('/admin/settings')
                -> type('min_password_length', 6)
                -> select('max_password_length', 12)
                -> check('one_capital')
                -> check('one_special')
                -> press('#submit');
        });

    }

    public function test_login()
    {
        $this -> login('trial@zentreasury.com', 'Abcde@123');
    }

    public function est_enable_change_password()
    {

    }

    public function est_enable_change_password_after_days()
    {

    }

    public function est_enable_lock_after_attempts()
    {

    }

    public function est_notify_login_diff_ip()
    {

    }

    public function login($userName, $password)
    {
        $this -> browse(function ($first) use ($userName, $password) {
            $first -> visit('/login')
                -> type('#inputEmail', $userName)
                -> select('#inputPassword', $password)
                -> press('#submit');
        });
    }
}
