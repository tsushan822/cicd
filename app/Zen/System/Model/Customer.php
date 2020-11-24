<?php

namespace App\Zen\System\Model;

use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Request;
use Laravel\Spark\LocalInvoice;

class Customer extends SystemModel
{

    protected $fillable = ['name', 'fx_rate_source', 'team_id', 'terms_accepted_at', 'terms_of_service', 'ip_address', 'website_id', 'database'];

    public function backUp()
    {
        return $this -> hasOne(BackUp::class, 'customer_id', 'id');
    }

    public function website()
    {
        return $this -> belongsTo(Website::class, 'website_id', 'id');
    }

    public function module()
    {
        return $this -> hasOne(Module::class, 'customer_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query -> where('active_status', 1);
    }

    public function setIpAddress()
    {
        $this -> attributes['ip_address'] = Request ::ip();
    }

    public function setTermsOfServic()
    {
        $this -> attributes['terms_of_service'] = file_get_contents(base_path('terms.md'));
    }

    public function localInvoices()
    {
        return $this -> hasMany(LocalInvoice::class) -> orderBy('id', 'desc');
    }

    public function team()
    {
        return $this -> hasOne(Team::class);
    }

    public function executeCommand()
    {
        return $this -> hasMany(ExecuteCommand::class);
    }


}
