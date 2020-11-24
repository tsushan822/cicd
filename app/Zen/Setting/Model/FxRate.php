<?php

namespace App\Zen\Setting\Model;

use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;


class FxRate extends BaseModel
{
    use RecordsActivity;
    static $recordEvents = ['updated', 'deleted'];

    protected $fillable = ['ccy_base_id', 'ccy_cross_id', 'direct_quote', 'date', 'rate_bid', 'user_id', 'updated_user_id'];

    public function baseCurrency()
    {
        return $this -> belongsTo(Currency::class, 'ccy_base_id');
    }

    public function crossCurrency()
    {
        return $this -> belongsTo(Currency::class, 'ccy_cross_id');
    }

}
