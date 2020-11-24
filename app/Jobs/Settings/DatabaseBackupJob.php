<?php

namespace App\Jobs\Settings;

use App\Zen\Client\Service\BackUpDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DatabaseBackupJob implements ShouldQueue
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
     */
    public function handle()
    {
        sleep(3);
        (new BackUpDatabase($this -> website_id)) -> backUp();
        return;
    }
}
