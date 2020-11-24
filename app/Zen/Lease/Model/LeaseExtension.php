<?php

namespace App\Zen\Lease\Model;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Event\CreateLeaseExtension;
use App\Zen\Lease\Event\DeleteLeaseExtension;
use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseExtension extends BaseModel
{
    use CreateLeaseExtension;
    use DeleteLeaseExtension;
    use SoftDeletes;
    use RecordsActivity;

    protected $fillable = ['lease_id', 'date_of_change', 'extension_start_date', 'extension_end_date', 'extension_period_amount',
        'extension_service_cost', 'extension_total_cost', 'lease_extension_rate', 'decrease_in_scope_rate', 'lease_extension_type',
        'user_id', 'extension_penalties_for_terminating', 'extension_residual_value_guarantee', 'extension_exercise_price'];
    protected static $columnsName = [];

    public function leaseFlow()
    {
        return $this -> hasMany(LeaseFlow::class);
    }

    public function firstLeaseFlow()
    {
        return $this -> hasOne(LeaseFlow::class) -> oldest('id');
    }

    public function lease()
    {
        return $this -> belongsTo(Lease::class) -> withoutGlobalScope(LeaseAccountableScope::class);
    }

    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    public function allowedLease()
    {
        return $this -> belongsTo(Lease::class) -> refactorEntity();
    }

    public function allowedLeaseAccountable()
    {
        return $this -> belongsTo(Lease::class) -> refactorEntity();
    }

    public function setExtensionEndDateAttribute($value)
    {
        $this -> attributes['extension_end_date'] = Carbon ::parse($value) -> endOfMonth() -> toDateString();
    }
}
