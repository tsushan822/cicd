<?php

namespace App\Zen\Lease\Model;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Setting\Model\BusinessDayConvention;
use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseType extends BaseModel
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'lease_types';

    /**
     * The database primary key value.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     * @var array
     */
    protected $fillable = ['type', 'description', 'lease_type_item', 'business_day_convention_id', 'updated_user_id',
        'user_id', 'lease_valuation_rate', 'interest_calculation_method', 'payment_type', 'extra_payment_in_fees', 'exclude_first_payment'];

    public function businessDayConvention()
    {
        return $this -> belongsTo(BusinessDayConvention::class);
    }

    public function leases()
    {
        return $this -> hasMany(Lease::class, 'lease_type_id', 'id');
    }

    public function allLeases()
    {
        return $this -> hasMany(Lease::class, 'lease_type_id', 'id') -> withoutGlobalScope(LeaseAccountableScope::class);
    }

}
