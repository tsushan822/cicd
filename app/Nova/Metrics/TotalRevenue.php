<?php

namespace App\Nova\Metrics;

use App\Zen\System\Model\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class TotalRevenue extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->sum($request, Contract::class, 'monthly_fee');
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
        return 'total-revenue';
    }

    /**
     * Get the URI label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Estimated Revenue Per Month';
    }
}
