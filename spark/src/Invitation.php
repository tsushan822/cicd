<?php

namespace Laravel\Spark;

use App\Zen\User\Model\BaseModel;
use Carbon\Carbon;

class Invitation extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invitations';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the team that owns the invitation.
     */
    public function team()
    {
        return $this->belongsTo(Spark::teamModel(), 'team_id');
    }

    /**
     * Determine if the invitation is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now()->subWeek()->gte($this->created_at);
    }
}
