<?php

namespace App\Zen\Setting\Model;

use App\Zen\Lease\Model\Lease;
use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'long_name', 'is_imported_deals', 'user_id', 'updated_user_id'];

    public function leases()
    {
        return $this -> hasMany(Lease::class, 'portfolio_id', 'id');
    }
}
