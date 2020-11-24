<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/06/2018
 * Time: 13.00
 */

namespace App\Scopes;

use App\Zen\User\Permission\AllowedEntity;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EntityScope implements Scope
{
    use AllowedEntity;

    /**
     * Apply the scope to a given Eloquent query builder.
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $entityId = $this -> getAllowedEntity();
        $builder -> whereIn('id', $entityId);
    }
}