<?php

namespace App\Zen\System\Observer;


use App\Zen\Setting\Service\DataBondService;
use App\Zen\System\Model\Customer;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomerObserver
{

    /**
     * Listen to the User created event.
     * @param Customer $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        Log ::critical('New customer created. Customer name: ' . $customer -> name);
    }

    /**
     * Listen to the User created event.
     * @param Customer $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        if($customer -> isDirty('databond_source_id')) {
            $response = DataBondService ::dataBondLogin();
            $bearerToken = json_decode($response) -> data;
            try {
                (new DataBondService) -> setBearerToken($bearerToken) -> addDataBondRateClient($customer -> databond_client_id, $customer -> databond_source_id);
            } catch (Exception $e) {
                Log ::critical($e -> getMessage());
            }
        }
    }


}