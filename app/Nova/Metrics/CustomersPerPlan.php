<?php

namespace App\Nova\Metrics;

use App\Zen\System\Model\Contract;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class CustomersPerPlan extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Contract::class, 'plan_type');
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
        return 'customers-per-plan';
    }

    /**
     * Get the URI label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Customer By Plan';
    }
}
