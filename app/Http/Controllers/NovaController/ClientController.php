<?php


namespace App\Http\Controllers\NovaController;


use App\Zen\System\Model\Customer;

class ClientController
{
    public function getclientsinfo()
    {
        $tenants = Customer::with('module')->get();

        return $tenants;
    }

}