<?php


namespace App\Scopes;


use App\Zen\System\Model\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Laravel\Spark\Spark;

class UserCompanyScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $website = \Hyn\Tenancy\Facades\TenancyFacade ::website();
        $customer = Customer ::where('website_id', $website -> id) -> first();
        return $builder -> where('current_team_id', '=', $customer -> team_id) -> orWhereIn('id', [1]);
    }
}