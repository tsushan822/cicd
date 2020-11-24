<?php

namespace App\Jobs\Settings;

use App\Zen\Setting\Service\FxRateImportService;
use App\Zen\System\Model\Customer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateFxRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $website_id;
    public $currencies;
    protected $updateFromMain;
    protected $customer;


    /**
     * UpdateFxRateJob constructor.
     * @param int $website_id
     * @param bool $updateFromMain
     */
    public function __construct(int $website_id, bool $updateFromMain = false)
    {
        $this -> website_id = $website_id;
        $this -> updateFromMain = $updateFromMain;
        $this -> customer = Customer ::where('website_id', $this -> website_id) -> first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = Carbon ::today() -> toDateString();

        if($this -> updateFromMain) {
            (new FxRateImportService($this -> customer)) -> updateFromMainDatabase($today);
        } else {
            (new FxRateImportService($this -> customer)) -> updateFromDataBond();
        }


    }

}
