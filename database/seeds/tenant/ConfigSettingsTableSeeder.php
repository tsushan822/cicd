<?php

namespace Seeds\Tenant;

use App\Zen\Setting\Model\ConfigSetting;
use Illuminate\Database\Seeder;

class ConfigSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        ConfigSetting ::truncate();

        ConfigSetting ::create([
            'type' => 'long_forecast_starting_month',
            'description' => 'Shows the month that is used as starting month for Fxforecasts reporting',
            'value_date' => date('2015-09-01'),
        ]);
        ConfigSetting ::create([
            'type' => 'short_forecast_starting_day',
            'description' => 'Shows the week that is used as starting month for short term liquidity reporting',
            'value_date' => date('2015-09-14'), //add validation to be on monday
        ]);
        ConfigSetting ::create([
            'type' => 'fx_forecasting_period_lock',
            'description' => 'Fx Forecasting is locked',
            'active' => 0,
        ]);
        ConfigSetting ::create([
            'type' => 'fxrate_starting_period',
            'description' => 'Shows the date when rates are available',
            // 'value_date'=>date('2015-09-14'), //add validation to be on monday
        ]);
        ConfigSetting ::create([
            'type' => 'number_of_forecasting_days',
            'description' => 'Number of short forecasting days',
            'value_int' => 3, //add validation to be on monday
        ]);
        ConfigSetting ::create([
            'type' => 'number_of_forecasting_month',
            'description' => 'Number of long forecasting months',
            'value_int' => 6, //add validation to be on monday
        ]);
    }
}
