<?php

namespace App\Console\Commands\Settings\Rates;

use App\Zen\Setting\Update\FxRate\ComponentaRateUpdate;
use App\Zen\Setting\Update\FxRate\ECBRateUpdate;
use App\Zen\Setting\Update\FxRate\RiksBankRateUpdate;
use App\Zen\User\UserList\AllUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notifiable;

class UpdateFxRatesApi extends Command
{
    use Notifiable;
    use AllUser;
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'rate:ECB';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Downloads latest ECB fixing rates';


    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {

        $this->ecbFxRate();

        $this->riksBankFxRate();


        //AdminNotify ::send(new CommandExecuted($this -> getTask()));
        return;
    }

    public function getTask()
    {
        return (object) [
            'title' => 'ECB Rate command',
            'description' => 'ECB Rate command has been executed on ' . Carbon::now('Europe/Helsinki')->toDateTimeString(),
        ];
    }

    public function ecbFxRate(): void
    {
        //Ecb bank rate
        $ecbRateObj = new ECBRateUpdate();
        $ecbRateObj->update();
    }


    public function riksBankFxRate(): void
    {
        //Riks Bank
        $riksBankRateObj = new RiksBankRateUpdate();
        $riksBankRateObj->update();
    }
}