<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;

class AuditTrail extends BaseModel
{
    protected $fillable = ['user_id', 'table_id', 'model', 'event', 'before', 'after'];

    /**
     * Get the user responsible for the given activity.
     */
    public function user()
    {
        return $this -> belongsTo(User::class);
    }

    /**
     * Get the subject of the activity.
     * @return mixed
     */
    public function subject()
    {
        return $this -> morphTo();
    }

    public function scopeFilter($query)
    {
        if(request() -> get('accounting_start_date') && request() -> get('accounting_end_date')) {
            $query -> whereBetween('created_at', [request() -> get('accounting_start_date'), request() -> get('accounting_end_date')]);
        }

        if(request() -> get('user_id')) {
            $query -> where('user_id', request() -> get('user_id'));
        }
        return $query;
    }
}
