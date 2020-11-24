<?php

namespace App\Zen\System\Model;


class Module extends SystemModel
{
    protected $fillable = ['name', 'available_number', 'plan_type','customer_id','available','module_usage'];

    public function customer()
    {
        return $this -> belongsTo(Customer::class);
    }
}
