<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 12/02/2019
 * Time: 11.42
 */

namespace App\Repository\Eloquent;


use App\Zen\Setting\Service\AdminSettingService;
use Illuminate\Support\Facades\Gate;

abstract class FreezeRepository extends Repository
{
    public function saveButtonWithDateFreeze($date, $permission)
    {
        return $this -> checkPermission($permission) && (AdminSettingService ::dateFreezeDateForEdit($date));
    }

    public function checkPermission($permission)
    {
        return !Gate ::denies($permission);
    }

    public function deleteButtonWithDateFreeze($date, $permission)
    {
        return (!Gate ::denies($permission) && (AdminSettingService ::dateFreezeDate($date)));
    }

    public function deleteExtButtonWithDateFreeze($date, $permission)
    {
        return (!Gate ::denies($permission) && (AdminSettingService ::dateFreezeDate($date)));
    }

    public function copyButtonWithDateFreeze($permission)
    {
        return (!Gate ::denies($permission));
    }

    public function addNewButtonWithDateFreeze($permission)
    {
        return (!Gate ::denies($permission));
    }

    public function clearAllButtonWithDateFreeze($date, $permission)
    {
        return (!Gate ::denies($permission) && (AdminSettingService ::dateFreezeDate($date)));
    }

    public function actionButtonWithDateFreeze($date, $permission)
    {
        return (!Gate ::denies($permission) && (AdminSettingService ::dateFreezeDate($date)));
    }
}