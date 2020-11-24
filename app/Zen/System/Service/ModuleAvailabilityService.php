<?php

namespace App\Zen\System\Service;

use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\System\Model\Customer;
use App\Zen\System\Model\CustomPlan;
use App\Zen\System\Model\Module;
use App\Zen\System\Model\Team;
use App\Zen\User\Model\User;
use Illuminate\Support\Facades\Gate;

class ModuleAvailabilityService
{
    public static function availabilityCount($moduleName)
    {
        if($moduleName && app('websiteId')) {
            $customer = Customer :: where('website_id', app('websiteId')) -> first();
            $module = Module ::where('name', $moduleName) -> where('customer_id', $customer -> id) -> first();
            if($module instanceof Module) {
                if($moduleName == 'Lease' && $module -> available_number <= Lease ::count()) {
                    return false;
                }

                if($moduleName == 'User' && $module -> available_number <= User ::count()) {
                    return false;
                }

                if($moduleName == 'Company' && $module -> available_number <= Counterparty ::count()) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function checkAuditTrailAvailability()
    {
        $configCheck = config('zenlease.features.audit_trail');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkAttachmentsAvailability()
    {
        if(Gate ::denies('view_document'))
            return false;

        $configCheck = config('zenlease.features.attachments');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkReportLibraryAvailability()
    {
        if(Gate ::denies('save_report'))
            return false;

        $configCheck = config('zenlease.features.report_library');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkEmailNotificationsAvailability()
    {
        $configCheck = config('zenlease.features.email_notifications');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkYTDReportAvailability()
    {
        $configCheck = config('zenlease.features.ytd_report');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkFacilityOverviewAvailability()
    {
        $configCheck = config('zenlease.features.facility_overview');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkFacilityOverviewReportAvailability()
    {
        $configCheck = config('zenlease.features.facility_overview_report');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkLeaseValuationReportAvailability()
    {
        $configCheck = config('zenlease.features.lease_valuation_report');
        return self ::checkIfAvailable($configCheck);
    }


    public static function checkRoUByLeaseTypeReportAvailability()
    {
        $configCheck = config('zenlease.features.rou_by_lease_type_report');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkAdditionToLiabilityReportAvailability()
    {
        $configCheck = config('zenlease.features.addition_to_liability_report');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkAdditionToRoUReportAvailability()
    {
        $configCheck = config('zenlease.features.addition_to_rou_report');
        return self ::checkIfAvailable($configCheck);
    }

    public static function checkLeaseSummaryReportAvailability()
    {
        $configCheck = config('zenlease.features.lease_summary_report');
        return self ::checkIfAvailable($configCheck);
    }

    /**
     * @return mixed
     */
    private static function currentPlan()
    {
        $team = Team ::first();
        $customPlan = CustomPlan ::where('plan_id', $team -> current_billing_plan) -> where('team_id', $team -> id) -> first();
        return $customPlan instanceof CustomPlan ? $customPlan : (object)['plan_name' => 'Professional'];
    }

    /**
     * @param $configCheck
     * @return bool
     */
    private static function checkIfAvailable(array $configCheck): bool
    {
        $customPlan = self ::currentPlan();
        return in_array($customPlan -> plan_name, $configCheck) || (auth() -> user() -> teams[0] -> trial_ends_at && !auth() -> user() -> teams[0] -> trial_ends_at -> isPast());
    }


}