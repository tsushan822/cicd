<?php

namespace App\Zen\Lease\Model;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Setting\Model\Account;
use App\Zen\Lease\Event\UpdateLeaseFlow;
use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseFlow extends BaseModel
{
    use RecordsActivity;
    use SoftDeletes;
    use UpdateLeaseFlow;

    protected $fillable = ['lease_id', 'payment_date', 'start_date', 'end_date', 'locked', 'variations', 'fixed_payment',
        'interest_rate', 'account_id', 'description', 'account_id', 'user_id', 'fees', 'total_payment', 'repayment', 'updated_user_id',
        'liability_opening_balance', 'interest_cost', 'liability_closing_balance',
        'depreciation_opening_balance', 'depreciation', 'depreciation_closing_balance', 'lease_extension_id'];


    protected static $recordEvents = ['updated'];
    protected static $columnsName = ['payment_date', 'account_id', 'description', 'account_id', 'fees', 'fixed_payment'];

    public function account()
    {
        return $this -> belongsTo(Account::class);
    }

    public function lease()
    {
        return $this -> belongsTo(Lease::class) -> withoutGlobalScope(LeaseAccountableScope::class);
    }

    public function leaseExtension()
    {
        return $this -> belongsTo(LeaseExtension::class);
    }

}
