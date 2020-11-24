<?php

namespace App\Zen\System\Model;

class MainFx extends SystemModel
{
    protected $fillable = ['ccy_base_id','ccy_cross_id','rate_type','source','date','rate_bid'];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    public function baseCurrency()
    {
        return $this->belongsTo(MainCurrency::class,'ccy_base_id');
    }

    public function crossCurrency()
    {
        return $this->belongsTo(MainCurrency::class,'ccy_cross_id');
    }
}
