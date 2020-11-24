<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/06/2018
 * Time: 11.19
 */

namespace App\Zen\Lease\Calculate\IFRS\Asset;


use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\DecreaseInScope;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\DecreaseInTerm;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\IncreaseInScope;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseFlowService;

class AssetClosingBalance
{
    /**
     * @var LeaseExtension
     */
    private $leaseExtension;

    /**
     * AssetClosingBalance constructor.
     * @param LeaseExtension $leaseExtension
     */
    public function __construct(LeaseExtension $leaseExtension)
    {

        $this -> leaseExtension = $leaseExtension;
    }

    public function calculateAmountOfDepreciation()
    {
        $lastDepreciationClosing = 0;
        switch($this -> leaseExtension -> lease_extension_type){
            case 'Decrease In Scope':
                $lastDepreciationClosing = (new DecreaseInScope($this -> leaseExtension -> lease)) ->
                calculateAmountOfDepreciation($this -> leaseExtension -> id);
                return $lastDepreciationClosing;
                break;
            case 'Increase In Scope':
                $lastDepreciationClosing = (new IncreaseInScope($this -> leaseExtension -> lease)) ->
                calculateAmountOfDepreciation($this -> leaseExtension -> id);
                return $lastDepreciationClosing;
                break;
            case 'Decrease In Term':
                $lastDepreciationClosing = (new DecreaseInTerm($this -> leaseExtension -> lease)) ->
                calculateAmountOfDepreciation($this -> leaseExtension -> id);
                return $lastDepreciationClosing;
                break;
            default:
                break;
        }
        return $lastDepreciationClosing;
    }

    public function calculateLastDepreciation()
    {
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> leaseExtension -> lease, $this -> leaseExtension -> date_of_change);
        $lastDepreciationClosing = 0;
        switch($this -> leaseExtension -> lease_extension_type){
            case 'Decrease In Scope':
                $lastDepreciationClosing = (new DecreaseInScope($this -> leaseExtension -> lease)) ->
                lastDepreciationCalculation($lastFlow, $this -> leaseExtension);
                return $lastDepreciationClosing;
                break;
            case 'Increase In Scope':
                $lastDepreciationClosing = (new IncreaseInScope($this -> leaseExtension -> lease)) ->
                lastDepreciationCalculation($lastFlow, $this -> leaseExtension);
                return $lastDepreciationClosing;
                break;
            case 'Decrease In Term':
                $lastDepreciationClosing = (new DecreaseInTerm($this -> leaseExtension -> lease)) ->
                lastDepreciationCalculation($lastFlow, $this -> leaseExtension);
                return $lastDepreciationClosing;
                break;
            default:
                break;
        }
        return $lastDepreciationClosing;
    }
}