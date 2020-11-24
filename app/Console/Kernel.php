<?php

namespace App\Console;

use App\Console\Commands\CustomerModuleUsage;
use App\Console\Commands\DBBackUp;
use App\Console\Commands\DBCleanUp;
use App\Console\Commands\MaturingDealNotifyCommand;
use App\Console\Commands\Settings\Rates\FxRatePairUpdate;
use App\Console\Commands\Settings\Rates\UpdateFxRatesApi;
use App\Console\Commands\Settings\Rates\UpdateTenantFxRate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(MaturingDealNotifyCommand::class)->dailyAt('09:00');

        /*Backup*/
        $schedule->command(DBBackUp::class)->dailyAt('23:00');
        $schedule->command(DBCleanUp::class)->dailyAt('23:27');


        /*Fx rates*/
        $schedule->command(UpdateFxRatesApi::class)->weekdays()->at('23:52');
        $schedule->command(UpdateTenantFxRate::class)->weekdays()->at('23:55');
        $schedule -> command(FxRatePairUpdate::class) -> weekdays() -> at('23:58');


        /*Module usage by customer*/
        $schedule -> command(CustomerModuleUsage::class) -> dailyAt('20:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');



        require base_path('routes/console.php');
    }
}
