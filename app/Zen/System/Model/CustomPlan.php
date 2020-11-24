<?php

namespace App\Zen\System\Model;


class CustomPlan extends SystemModel
{
    protected $table = 'custom_plans';
    protected $fillable = ['plan_id', 'product_id', 'plan_name', 'plan_description', 'team_id', 'amount', 'add_ons', 'services', 'trial_days', 'period', 'features', 'fx_rate',
        'number_of_leases', 'number_of_users', 'number_of_companies'];
}
