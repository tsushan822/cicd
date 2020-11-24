<?php

namespace App\Zen\Setting\Model;

use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Traits\RecordsActivity;
use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Counterparty extends BaseModel
{
    use SoftDeletes;
    use RecordsActivity;

    protected $fillable = ['short_name', 'long_name', 'is_counterparty', 'is_entity', 'is_parent_company', 'is_external', 'currency_id',
        'postal_address', 'country_id', 'user_id', 'updated_user_id', 'ifrs_accounting', 'lease_rate', 'default_lease_rate', 'profit_center'];


    public function users()
    {
        return $this -> belongsToMany(User::class);
    }

    public function scopeParent($query)
    {
        return $query -> where('is_parent_company', 1)-> first();

    }

    public function scopeEntity($query)
    {
        return $query -> where('is_entity', 1);
    }

    public function scopeExternal($query)
    {
        return $query -> where('is_external', 1);
    }

    public function scopeInternal($query)
    {
        return $query -> where('is_external', 0);
    }

    public function scopeCounterparty($query)
    {
        return $query -> where('is_counterparty', 1);
    }

    public function currency()
    {
        return $this -> belongsTo(Currency::class);
    }


    public function accounts()
    {
        return $this -> hasMany(Account::class);
    }

    public function lessors()
    {
        return $this -> hasMany(Lease::class, 'counterparty_id', 'id');
    }

    public function leases()
    {
        return $this -> hasMany(Lease::class, 'entity_id', 'id');
    }


    public function scopeAllowedEntity($query)
    {
        $entityId = $this -> getAllowedEntity();
        return $query -> whereIn('id', $entityId);
    }

    /**
     * {@inheritdoc}
     */
    public function transformAudit(array $data): array
    {
        if(Arr ::has($data, 'new_values.currency_id')) {
            $data['old_values']['currency'] = Currency ::find($this -> getOriginal('currency_id')) -> iso_4217_code;
            $data['new_values']['currency'] = Currency ::find($this -> getAttribute('currency_id')) -> iso_4217_code;
        }

        return $data;
    }
}
