<?php

namespace App\Jobs\Settings;

use App\Zen\Setting\Notification\Maturing\EmailMaturingDeals;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MaturingDealCommandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var int
     */
    public $website_id;

    /**
     * Create a new job instance.
     *
     * @param int $website_id
     */
    public function __construct(int $website_id)
    {
        $this -> website_id = $website_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailMaturingObj = new EmailMaturingDeals();
        $emailMaturingObj -> setWebsiteId($this->website_id) -> sendNotification();
    }
}
