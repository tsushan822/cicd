<?php

namespace App\Zen\System\Model;

class MainCurrency extends SystemModel
{
    protected $fillable = ['iso_4217_code', 'iso_3166_code', 'iso_number', 'currency_name', 'active_status'];

    public function scopeActive($query)
    {
        return $query -> where('active_status', 1) -> orderBy('iso_4217_code', 'asc');
    }
}
