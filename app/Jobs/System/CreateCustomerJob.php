<?php

namespace App\Jobs\System;

use App\Zen\Client\Service\CreateCustomer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var array
     */
    private $customerData;

    /**
     * Create a new job instance.
     * @param array $customerData
     */
    public function __construct(array $customerData)
    {

        $this -> customerData = $customerData;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        (new CreateCustomer($this -> customerData)) -> createCustomer();
    }
}
