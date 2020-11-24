<?php

namespace App\Zen\User\Model;

use App\Notifications\CustomPasswordReset;
use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\Setting\Model\AuditTrail;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Dashboard;
use App\Zen\User\Event\CreateUser;
use App\Zen\User\Service\AuthenticationLogable;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Notifications\Notifiable;
use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\Spark;
use Laravel\Spark\User as SparkUser;

class User extends SparkUser
{
    use UsesTenantConnection;
    use Notifiable;
    use CreateUser;
    use AuthenticationLogable;
    use CanJoinTeams;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'locale', 'verified', 'must_change_password', 'active_status', 'two_factor_type', 'authy_id', 'dialing_code', 'phone_number', 'password_changed_at', 'wrong_password_blocked_at', 'current_team_id'];


    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'two_factor_reset_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    protected $attributes = ['must_change_password' => 0];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    protected static $recordEvents = ['created'];


    public function counterparties()
    {
        return $this -> belongsToMany(Counterparty::class);
    }

    public function scopeDevelopers()
    {
        return $this -> whereIn('email', Spark ::$developers);
    }

    public function scopeNonDevelopers()
    {
        return $this -> whereNotIn('email', Spark ::$developers);
    }

    public function isDeveloper()
    {
        return $this -> emails;
    }

    public function roles()
    {
        return $this -> belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this -> roles -> contains('name', $role);
        }
        return !!$role -> intersect($this -> roles) -> count();
    }

    public function assign($role)
    {
        if(is_string($role)) {
            return $this -> roles() -> save(
                Role ::whereName($role) -> firstOrFail()
            );
        }
        return $this -> roles() -> save($role);
    }

    public function dashboards()
    {
        return $this -> belongsToMany(Dashboard::class) -> withPivot('active_status');
    }

    /**
     * Get the activity timeline for the user.
     * @return mixed
     */
    public function auditTrail()
    {
        return $this -> hasMany(AuditTrail::class) -> with('user') -> latest();
    }

    public function account()
    {
        return $this -> belongsTo(Account::class, 'account_id');
    }

    public function routeNotificationForSlack()
    {
        return env('SLACK_WEBHOOK');
    }

    public function sendPasswordResetNotification($token)
    {
        $this -> notify(new CustomPasswordReset($token));

    }

    public function hasTwoFactorAuthenticationEnabled()
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            return $adminSetting -> active_all_auth && $this -> two_factor_type == 'app';
        }
        return $this -> two_factor_type == 'app';
    }

    public function registeredForTwoFactorAuthentication()
    {
        return $this -> authy_id !== null;
    }

    protected static function boot()
    {
        parent ::boot();

        //static ::addGlobalScope(new UserCompanyScope());
    }
}
