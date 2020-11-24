<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Seeds\System\HostNameTableSeeder;
use Seeds\System\MainCurrenciesTableSeeder;
use Seeds\System\WinkPageSeeder;

class SystemDatabaseSeeder extends Seeder
{
    public function run()
    {
        DB ::statement('SET FOREIGN_KEY_CHECKS = 0');
        $this -> call([
            MainCurrenciesTableSeeder::class,
            HostnameTableSeeder::class,
            WinkPageSeeder::class,
        ]);
        DB ::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}