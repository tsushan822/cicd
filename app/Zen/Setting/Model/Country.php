<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'iso_3166_code', 'is_EEA', 'currency_id', 'user_id', 'updated_user_id'];

    protected $attributes = ['is_EEA' => 0];

    public function currency()
    {
        return $this -> belongsTo(Currency::class);
    }
}
