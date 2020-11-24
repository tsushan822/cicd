<?php

namespace Seeds\Tenant;

use App\Zen\Setting\Model\Counterparty;
use Illuminate\Database\Seeder;

//use database\seeds\DatabaseSeeder;

class CounterpartiesTableSeeder extends Seeder
{

    public function run()
    {

        Counterparty ::truncate();

        //1
        $result = Counterparty ::create([
            'short_name' => 'Trial lessor',
            'long_name' => 'Trial lessor',
            'is_counterparty' => 1,
            'is_entity' => 0,
            'is_parent_company' => 0,
            'is_external' => 0,
            'currency_id' => 2,
            'postal_address' => 'PL 001 00100 HELSINKI',
            'country_id' => 9,
        ]);

    }

}
