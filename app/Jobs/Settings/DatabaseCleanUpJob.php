<?php

namespace App\Jobs\Settings;

use App\Zen\Client\Service\CleanUpDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DatabaseCleanUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $websiteId;

    /**
     * Create a new job instance.
     *
     * @param int $websiteId
     */
    public function __construct(int $websiteId)
    {
        $this -> websiteId = $websiteId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new CleanUpDatabase($this -> websiteId))->cleanUp();
        return;
    }
}
