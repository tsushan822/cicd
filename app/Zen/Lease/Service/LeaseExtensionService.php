<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 28/05/2018
 * Time: 15.43
 */

namespace App\Zen\Lease\Service;

use App\Exceptions\CustomException;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use Exception;

class LeaseExtensionService
{
    public static function earlierExtension($leaseExtensionId)
    {
        $leaseExtension = LeaseExtension ::findOrFail($leaseExtensionId);
        $previousExtension = LeaseExtension ::where('id', '<', $leaseExtensionId) -> where('lease_id', $leaseExtension -> lease_id) -> max('id');
        return LeaseExtension ::findOrFail($previousExtension);
    }

    public static function earlierExtensionDate($accountingDate, $lease)
    {
        $previousExtension = LeaseExtension ::where('date_of_change', '<', $accountingDate) -> where('lease_id', $lease -> id) -> orderBy('id', 'desc') -> first();
        return $previousExtension;
    }

    public static function allExtensions($lease)
    {
        $allExtensions = LeaseExtension ::where('lease_id', '=', $lease -> id) -> get();
        return $allExtensions;
    }

    public static function lastExtension($lease)
    {
        $lastExtension = LeaseExtension ::where('lease_id', '=', $lease -> id) -> orderBy('id', 'desc') -> first();
        return $lastExtension;
    }

    public static function lastExtensionAsc($lease)
    {
        $lastExtension = LeaseExtension ::where('lease_id', '=', $lease -> id) -> orderBy('id', 'asc') -> first();
        return $lastExtension;
    }

    public static function addComponentsOnEdit($lease)
    {
        $leaseExtension = LeaseExtensionService ::firstExtension($lease);
        if($leaseExtension instanceof LeaseExtension)
            self ::addComponentsAtFirstExtension($leaseExtension);
    }

    public static function addComponentsAtFirstExtension($leaseExtension)
    {
        try {
            $leaseExtension -> liability_conversion_rate = MonthEndConversionService ::monthEndLiabilityConversionRate($leaseExtension);
            $leaseExtension -> depreciation_conversion_rate = MonthEndConversionService ::monthEndDepreciationConversionRate($leaseExtension);
            $leaseExtension -> extension_exercise_price = $leaseExtension -> lease -> exercise_price;
            $leaseExtension -> extension_residual_value_guarantee = $leaseExtension -> lease -> residual_value_guarantee;
            $leaseExtension -> extension_penalties_for_terminating = $leaseExtension -> lease -> penalties_for_terminating;
            $leaseExtension -> save();
        } catch (Exception $e) {
            LeaseFlow ::where('lease_extension_id', $leaseExtension -> id) -> forcedelete();
            $leaseExtension -> forcedelete();
            flash() -> overlay(trans('master.Rate cannot be find for given pair')) -> message();
        }

    }

    public static function findTerminateDate(Lease $lease)
    {
        $lastExtension = self ::lastExtension($lease);
        if(($lastExtension instanceof LeaseExtension) && $lastExtension -> lease_extension_type == 'Terminate Lease') {
            return $lastExtension -> date_of_change;
        }
        return null;
    }

    public static function firstExtension($lease)
    {
        $lastExtension = LeaseExtension ::where('lease_id', '=', $lease -> id) -> orderBy('id', 'asc') -> first();
        return $lastExtension;
    }

    public static function leaseEndPaymentsForExtension($leaseExtension)
    {
        return $leaseExtension -> extension_exercise_price + $leaseExtension -> extension_residual_value_guarantee +
            $leaseExtension -> extension_penalties_for_terminating;
    }

}