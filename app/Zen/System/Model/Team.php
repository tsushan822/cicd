<?php

namespace App\Zen\System\Model;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Laravel\Spark\Invitation;
use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam
{
    use UsesTenantConnection;

    protected $fillable = ['id', 'name', 'slug', 'owner_id', 'customer_id', 'trial_ends_at'];

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $table = 'teams';

    public function customer()
    {
        return $this -> setConnection('system') -> hasOne(Customer::class,'team_id','id');
    }

    public function invitations()
    {
        return $this -> hasMany(Invitation::class, 'team_id');
    }


    public function onSoonExpiringTrial(): bool
    {
        if($this -> subscribed()) {
            return false;
        }

        if(!$this -> onGenericTrial()) {
            return false;
        }

        return now() -> addDays(2) -> greaterThan($this -> trial_ends_at);
    }

}
