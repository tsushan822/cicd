<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/11/2017
 * Time: 11.28
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LeaseAccountableScope implements Scope
{

    /**
     * @param Builder $builder
     * @param Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('non_accountable', '=', 0);
    }
}