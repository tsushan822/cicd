<?php

namespace App\Jobs\User;

use App\Zen\User\Service\AddUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $website_id;
    protected $userDetails;

    public function __construct(int $website_id, array $userDetails)
    {
        $this -> website_id = $website_id;
        $this -> userDetails = $userDetails;
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        (new AddUser()) -> addUser($this -> userDetails);
        return;
    }
}
