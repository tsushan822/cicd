<?php

namespace App\Zen\Setting\Model;

use App\Zen\Setting\Model\Currency;
use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class FxRatePair extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['base_currency', 'converting_currency', 'referencing_currency'];

    public function baseCurrency()
    {
        return $this -> belongsTo(Currency::class, 'base_currency');
    }

    public function convertingCurrency()
    {
        return $this -> belongsTo(Currency::class, 'converting_currency');
    }

    public function referencingCurrency()
    {
        return $this -> belongsTo(Currency::class, 'referencing_currency');
    }
}
