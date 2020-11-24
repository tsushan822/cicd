<?php
namespace Seeds\Tenant;

use App\Zen\Setting\Model\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder {

    public function run() {

        Account::truncate();

        Account::create([
            'counterparty_id' => '1',
            'account_name' => 'USD',
            'currency_id' => '2',
        ]);

    }

}
