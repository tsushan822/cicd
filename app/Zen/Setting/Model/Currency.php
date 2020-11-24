<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends BaseModel
{
    use SoftDeletes;

    protected $auditEvents = ['updated'];

    protected $fillable = ['iso_4217_code', 'iso_3166_code', 'iso_number', 'currency_name', 'active_status', 'user_id', 'updated_user_id'];

    public function country()
    {
        return $this -> belongsTo(Country::class) -> withTrashed();
    }

    public function scopeActive($query)
    {
        return $query -> where('active_status', 1) -> orderBy('iso_4217_code', 'asc');
    }
}
