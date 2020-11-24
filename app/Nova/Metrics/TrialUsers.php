<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Illuminate\Support\Facades\DB;


class TrialUsers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $CustomerOnTrial= DB::Connection('system')->table('teams')
           ->whereNull('trial_ends_at')
           ->orWhere('trial_ends_at', '<=', now())
            ->count();
        return $this->result($CustomerOnTrial);

    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [

        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'trial-users';
    }

}
