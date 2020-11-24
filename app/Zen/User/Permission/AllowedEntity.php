<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/06/2018
 * Time: 15.48
 */

namespace App\Zen\User\Permission;


use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;

trait AllowedEntity
{
    public function getAllowedEntity($user = null)
    {
        if(!$user && Auth ::check())
            $user = Auth ::user();
        if(!$user)
            throw new CustomException(trans('master.User not found.'));
        return $user -> counterparties -> pluck('id') -> toArray();

    }

    public function checkIfAllowedForThisEntity($entityId, $user = null)
    {
        $returnValue = $this -> checkIfAllowedForThisEntityNoException($entityId, $user);
        if(!$returnValue)
            throw new CustomException(trans('master.User has no access to this entity.'));
        return true;
    }

    public function checkIfAllowedForThisEntityNoException($entityId, $user = null)
    {
        $allowedEntity = $this -> getAllowedEntity($user);
        if(in_array($entityId, $allowedEntity))
            return true;
        return false;
    }
}