<?php

namespace App\Zen\Setting\Model;


use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends BaseModel
{
    use SoftDeletes;
    use RecordsActivity;

    protected $appends = ['pivot_percentage'];

    protected $fillable = ['short_name', 'long_name','user_id', 'updated_user_id'];

    public function counterparty()
    {
        return $this -> belongsTo(Counterparty::class, 'counterparty_id') -> withTrashed();
    }

    public function portfolio()
    {
        return $this -> belongsTo(Portfolio::class, 'portfolio_id') -> withTrashed();
    }

    public function currency()
    {
        return $this -> belongsTo(Currency::class, 'currency_id') -> withTrashed();
    }

    public function getPivotPercentageAttribute()
    {
        if($this -> pivot)
            return $this -> pivot -> percentage / 100;
    }

    public function leases()
    {
        return $this -> hasMany(Lease::class, 'cost_center_id', 'id');
    }

}
