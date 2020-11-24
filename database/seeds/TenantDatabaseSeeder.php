<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Seeds\Tenant\BusinessDayConventionTableSeeder;
use Seeds\Tenant\CounterpartiesTableSeeder;
use Seeds\Tenant\CountriesTableSeeder;
use Seeds\Tenant\CurrenciesTableSeeder;
use Seeds\Tenant\LeaseTableSeeder;
use Seeds\Tenant\LeaseTypeSeeder;
use Seeds\Tenant\PermissionsTableSeeder;
use Seeds\Tenant\PortfoliosTableSeeder;
use Seeds\Tenant\RolesTableSeeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB ::statement('SET FOREIGN_KEY_CHECKS = 0');
        $this -> call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            CurrenciesTableSeeder::class,
            CountriesTableSeeder::class,
            PortfoliosTableSeeder::class,
            BusinessDayConventionTableSeeder::class,
            CounterpartiesTableSeeder::class,
            LeaseTypeSeeder::class,
            //Lease seeder made in class since seeder is not working at the time of creation
            //LeaseTableSeeder::class
        ]);
        DB ::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
