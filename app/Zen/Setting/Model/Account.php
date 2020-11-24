<?php
namespace App\Zen\Setting\Model;


use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['counterparty_id', 'account_name', 'client_account_number', 'client_account_name', 'balance_sheet',
        'IBAN', 'BIC', 'currency_id', 'country_id', 'bank', 'show_liq_view', 'user_id', 'updated_user_id'];


    public function Counterparty()
    {
        return $this -> belongsTo(Counterparty::class);
    }


    public
    function currency()
    {
        return $this -> belongsTo(Currency::class);
    }

    public
    function country()
    {
        return $this -> belongsTo(Country::class);
    }



    public function ssi()
    {
        return $this -> hasMany(Ssi::class);
    }

    public
    function createdByUser()
    {

        return $this -> belongsTo(User::class, 'user_id');
    }

    public
    function updatedByUser()
    {
        return $this -> belongsTo(User::class, 'updated_user_id');
    }

    public function scopeRefactorEntity($query, $user = null)
    {
        $entityArray = $this -> getAllowedEntity($user);
        return $query -> whereIn('counterparty_id', $entityArray);
    }

    /*Put this to delete all dealflows when deleting loan*/
    protected static function boot()
    {
        parent ::boot();

    }

}