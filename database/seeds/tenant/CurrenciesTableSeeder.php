<?php

namespace Seeds\Tenant;

use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\Currency;
use App\Zen\System\Model\MainCurrency;
use Illuminate\Database\Seeder;

//http://en.wikipedia.org/wiki/ISO_4217
//http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 *except eu check famfamfam website
class CurrenciesTableSeeder extends Seeder
{

    public function run()
    {
        $allCurrencies = MainCurrency ::all();
        foreach($allCurrencies as $currency)
        {
            $attr = [
                'iso_4217_code' => $currency -> iso_4217_code,
                'iso_3166_code' => $currency -> iso_3166_code,
                'iso_number' => $currency -> iso_number,
                'currency_name' => $currency -> currency_name,
                'active_status' => $currency -> active_status,
            ];
            $createdCurrency = Currency::create($attr);

            $attrAccount = [
                'counterparty_id' => '2',
                'account_name' => $createdCurrency -> iso_4217_code,
                'currency_id' => $createdCurrency -> id,
            ];
            Account::create($attrAccount);
        }
    }
}