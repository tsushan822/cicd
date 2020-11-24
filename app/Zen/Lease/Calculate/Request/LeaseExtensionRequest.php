<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/05/2018
 * Time: 10.25
 */

namespace App\Zen\Lease\Calculate\Request;

use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\DecreaseInScope;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\DecreaseInTerm;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\IncreaseInScope;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\TerminateLease;
use App\Zen\Setting\Service\Currency\CurrencyService;
use App\Zen\Lease\Service\LeaseFlowService;


class LeaseExtensionRequest
{
    public static function leaseExtension($request, $lease)
    {
        switch($request -> lease_extension_type){
            case 'Decrease In Scope':
                $increaseInScope = new DecreaseInScope($lease);
                $increaseInScope -> updateLeaseFlows();
                if($lease -> ifrs_accounting) {
                    $increaseInScope -> updateLiability();
                    $increaseInScope -> updateDepreciation();
                    $increaseInScope -> updateConversionRate();
                }
                break;

            case 'Increase In Scope':
                $decreaseInScope = new IncreaseInScope($lease);
                $decreaseInScope -> updateLeaseFlows();
                if($lease -> ifrs_accounting) {
                    $decreaseInScope -> updateLiability();
                    $decreaseInScope -> updateDepreciation();
                    $decreaseInScope -> updateConversionRate();
                }
                break;

            case 'Decrease In Term':
                $decreaseInTerm = new DecreaseInTerm($lease);
                $decreaseInTerm -> updateLeaseFlows();
                if($lease -> ifrs_accounting) {
                    $decreaseInTerm -> updateLiability();
                    $decreaseInTerm -> updateDepreciation();
                    $decreaseInTerm -> updateConversionRate();
                }
                break;

            case 'Terminate Lease':
                $terminateLease = new TerminateLease($lease);
                $terminateLease -> updateLeaseFlows() -> createLeaseExtension();
                $baseCurrency = CurrencyService ::getCompanyBaseCurrency($lease -> entity_id);
                if($lease -> ifrs_accounting && $baseCurrency -> id != $lease -> currency_id) {
                    $terminateLease -> updateConversionRate();
                }
                break;

            default:
                break;
        }
        if($lease -> ifrs_accounting) {
            LeaseFlowService ::updateRepayment($lease -> id);
            LeaseFlowService ::updateShortLiabilityWithLease($lease);
        }
    }
}