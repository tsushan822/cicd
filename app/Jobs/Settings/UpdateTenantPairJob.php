<?php


namespace App\Jobs\Settings;

use App\Zen\Setting\Calculate\RatePair\Update;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTenantPairJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $website_id;

    public function __construct(int $website_id)
    {
        $this -> website_id = $website_id;
    }

    /**
     * Execute the console command.
     * @return mixed
     * @throws \App\Exceptions\CustomException
     */
    public function handle()
    {
        Update ::updateRatePair();
    }

}