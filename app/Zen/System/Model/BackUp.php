<?php

namespace App\Zen\System\Model;

class BackUp extends SystemModel
{
    protected $fillable = ['customer_id', 'always_backup', 'monthly_backup', 'backup_days', 'fx_rate_source'];

    public function customer()
    {
        return $this -> belongsTo(Customer::class);
    }

    protected $attributes = ['always_backup' => 0, 'monthly_backup' => 1, 'backup_days' => 7];
}
