<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 21/03/2018
 * Time: 16.40
 */
namespace App\Zen\Setting\Service;


use App\Zen\Setting\Model\AdminSetting;
use Illuminate\Support\Carbon;

class AdminSettingService
{
    public static function dateFreezeDate($checkDate)
    {
        $adminSetting = AdminSetting ::first();
        if(!$adminSetting instanceof AdminSetting)
            return true;

        if(!$adminSetting -> date_freezer_active)
            return true;

        return Carbon ::parse($adminSetting -> freezer_date) -> toDateString() < $checkDate;

    }

    public static function dateFreezeDateForEdit($checkDate)
    {
        $adminSetting = AdminSetting ::first();
        if(!$adminSetting instanceof AdminSetting)
            return true;

        if(!$adminSetting -> date_freezer_active || $adminSetting -> date_freezer_active == 'Adjustable')
            return true;

        return Carbon ::parse($adminSetting -> freezer_date) -> toDateString() < $checkDate;

    }
}