<?php

namespace App\Zen\System\Model;


class FxRateSource extends SystemModel
{
    protected $table = 'fx_rate_sources';
    protected $fillable = ['source_id', 'source'];
}
