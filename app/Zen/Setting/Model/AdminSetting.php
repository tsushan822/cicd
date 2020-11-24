<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;

class AdminSetting extends BaseModel
{
    protected $fillable = ['user_id', 'freezer_date', 'date_freezer_active', 'auth_log', 'active_all_auth', 'min_password_length', 'max_password_length', 'password_criteria', 'enable_cost_center_split',
        'number_of_unsuccessful_login', 'password_change_days', 'enable_change_password', 'enable_failed_login_lock'];

    protected $attributes = ['active_all_auth' => true];
}
