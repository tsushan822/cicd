<?php

namespace App\Zen\Lease\Model;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Setting\MOdel\Account;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lease extends BaseModel
{
    use SoftDeletes;
    use RecordsActivity;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'leases';


    protected $casts = [
        'lease_amount' => 'float',
        'lease_service_cost' => 'float',
        'total_lease' => 'float',
        'exercise_price' => 'float',
        'residual_value_guarantee' => 'float',
        'penalties_for_terminating' => 'float',
        'payment_before_commencement_date' => 'float',
        'initial_direct_cost' => 'float',
        'cost_dismantling_restoring_asset' => 'float',
        'lease_incentives_received' => 'float',
        'residual_value' => 'float',
        'number_of_parking_spaces' => 'integer',
    ];

    /**
     * The database primary key value.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     * @var array
     */
    protected $fillable = ['entity_id', 'cost_center_id', 'portfolio_id', 'counterparty_id', 'currency_id', 'account_id',
        'effective_date', 'lease_rate', 'maturity_date', 'ifrs_accounting', 'user_id', 'updated_user_id','source',
        'non_accountable', 'is_archived', 'lease_amount', 'lease_service_cost', 'total_lease', 'first_payment_date',
        'exercise_price', 'residual_value_guarantee', 'penalties_for_terminating', 'payment_before_commencement_date',
        'initial_direct_cost', 'cost_dismantling_restoring_asset', 'lease_incentives_received', 'lease_flow_per_year', 'lease_type_id', 'payment_day', 'rate_type', 'contractual_end_date',
        'customer_reference', 'residual_value', 'text', 'calculate_valuation', 'cost_center_split', 'internal_order', 'tax', 'rou_asset_number',
        'agreement_type', 'contracts_first_possible_termination_day', 'notice_period_in_months', 'lease_end_date', 'square_metres', 'grained_surface_area',
        'number_of_employees', 'number_of_workstations', 'parking_cost_per_month', 'number_of_parking_spaces', 'capital_rent_per_month', 'maintenance_rent_per_month', 'other_cost_per_month',
        'total_costs_affecting_rent', 'renovation_and_rent_free_periods', 'rent_security_deposit', 'rent_security_type', 'rent_security_expiry_date', 'rent_security_received_back', 'show_agreement_in_report'];

    public function entity()
    {
        return $this -> belongsTo(Counterparty::class, 'entity_id') -> withTrashed();
    }

    public function counterparty()
    {
        return $this -> belongsTo(Counterparty::class, 'counterparty_id') -> withTrashed();
    }

    public function currency()
    {
        return $this -> belongsTo(Currency::class) -> withTrashed();
    }

    public function costCenter()
    {
        return $this -> belongsTo(CostCenter::class);
    }

    public function costCenters()
    {
        return $this -> belongsToMany(CostCenter::class) -> withPivot('percentage');
    }

    public function portfolio()
    {
        return $this -> belongsTo(Portfolio::class) -> withTrashed();
    }

    public function account()
    {
        return $this -> belongsTo(Account::class, 'account_id') -> withTrashed();
    }

    public function leaseType()
    {
        return $this -> belongsTo(LeaseType::class, 'lease_type_id') -> withTrashed();
    }

    public function leaseFlow()
    {
        return $this -> hasMany(LeaseFlow::class);
    }

    public function leaseExtension()
    {
        return $this -> hasMany(LeaseExtension::class);
    }

    public function scopeRefactorEntity($query, $user = null)
    {
        $entityArray = $this -> getAllowedEntity($user);
        return $query -> whereIn('entity_id', $entityArray);
    }

    public function scopeArchive($query)
    {
        return $query -> where('is_archived', 1) -> orWhere('maturity_date', '<', Carbon ::today() -> toDateString());
    }

    public function scopeNonArchive($query)
    {
        return $query -> where('is_archived', 0) -> where('maturity_date', '>=', Carbon ::today() -> toDateString());
    }

    public function scopeFilter($query)
    {
        if(request() -> get('entity_id')) {
            if(!is_array(request() -> get('entity_id'))) {
                $query = $query -> where('entity_id', request() -> entity_id);
            } else {
                if(!is_null(request() -> get('entity_id')[0]))
                    $query = $query -> whereIn('entity_id', request() -> entity_id);
            }
        }

        if(request() -> get('lease_type_id')) {
            if(!is_array(request() -> get('lease_type_id'))) {
                $query = $query -> where('lease_type_id', request() -> lease_type_id);
            } else {
                if(!is_null(request() -> get('lease_type_id')[0]))
                    $query = $query -> whereIn('lease_type_id', request() -> lease_type_id);
            }
        }

        if(request() -> get('portfolio_id')) {
            if(!is_array(request() -> get('portfolio_id'))) {
                $query = $query -> where('portfolio_id', request() -> portfolio_id);
            } else {
                if(!is_null(request() -> get('portfolio_id')[0]))
                    $query = $query -> whereIn('portfolio_id', request() -> portfolio_id);
            }
        }

        if(request() -> get('counterparty_id')) {
            if(!is_array(request() -> get('counterparty_id'))) {
                $query = $query -> where('counterparty_id', request() -> counterparty_id);
            } else {
                if(!is_null(request() -> get('counterparty_id')[0]))
                    $query = $query -> whereIn('counterparty_id', request() -> counterparty_id);
            }
        }

        $query = $this -> costCenterSearch($query);

        if(request() -> get('lease_id')) {
            $query = $query -> where('id', request() -> lease_id);
        }
        return $query;
    }

    public function scopeIFRSLease($query)
    {
        return $query -> where('ifrs_accounting', 1);
    }

    public function scopeReportable($query, $uer = null)
    {
        return $query -> filter() -> refactorEntity();
    }

    public function setFirstPaymentDateAttribute($value)
    {
        $this -> attributes['first_payment_date'] = Carbon ::parse($value) -> endOfMonth() -> toDateString();
    }

    public function setEffectiveDateAttribute($value)
    {
        $this -> attributes['effective_date'] = Carbon ::parse($value) -> startOfMonth() -> toDateString();
    }

    public function setAccountIdAttribute($value)
    {
        if(!$value)
            $this -> attributes['account_id'] = $this -> attributes['currency_id'];
        else
            $this -> attributes['account_id'] = $value;
    }

    public function setMaturityDateAttribute($value)
    {
        $this -> attributes['maturity_date'] = Carbon ::parse($value) -> endOfMonth() -> toDateString();
    }

    public function setContractualEndDateAttribute($value)
    {
        if(!$value)
            $this -> attributes['contractual_end_date'] = $this -> attributes['maturity_date'];
        else
            $this -> attributes['contractual_end_date'] = $value;
    }

    public function setGrainedSurfaceAreaAttribute($value)
    {
        if(!floatval($value)) {
            $this -> attributes['grained_surface_area'] = $this -> attributes['square_metres'];
        } else {
            $this -> attributes['grained_surface_area'] = $value;
        }
    }

    protected static function boot()
    {
        parent ::boot();

        static ::addGlobalScope(new LeaseAccountableScope);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function costCenterSearch($query)
    {

        if(app('costCenterSplitAdmin')) {
            if(request() -> get('cost_center_id')) {
                if(!is_array(request() -> get('cost_center_id'))) {
                    $query = $query -> where(function ($que) {
                        $que -> whereHas('costCenters', function ($q) {
                            $q -> where('cost_centers.id', request() -> cost_center_id);
                        }) -> orWhere('cost_center_id', request() -> cost_center_id);
                    });
                } else {
                    if(!is_null(request() -> get('cost_center_id')[0])) {
                        $query = $query -> where(function ($que) {
                            $que -> whereHas('costCenters', function ($q) {
                                $q -> whereIn('id', request() -> cost_center_id);
                            }) -> orWhereIn('cost_center_id', request() -> cost_center_id);
                        });
                    }
                }
            }
        } else {
            if(request() -> get('cost_center_id')) {
                if(!is_array(request() -> get('cost_center_id'))) {
                    $query = $query -> where('cost_center_id', request() -> cost_center_id);
                } else {
                    if(!is_null(request() -> get('cost_center_id')[0]))
                        $query = $query -> whereIn('cost_center_id', request() -> cost_center_id);
                }
            }
        }
        return $query;
    }
}
