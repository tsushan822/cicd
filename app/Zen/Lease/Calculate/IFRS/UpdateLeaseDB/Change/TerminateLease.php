<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/06/2018
 * Time: 10.54
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change;

use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEdited;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Lease\Service\MonthEndConversionService;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TerminateLease extends LeaseEdited
{
    public function createLeaseExtension()
    {
        request() -> request -> add(['user_id' => Auth ::id(), 'lease_id' => $this -> lease -> id,
            'extension_start_date' => request() -> date_of_change, 'extension_end_date' => request() -> date_of_change]);
        $leaseExtension = LeaseExtension ::create(request() -> all());
        $this -> setExtensionId($leaseExtension -> id);
        return $this;

    }

    public function updateLeaseFlows()
    {
        $dateOfChange = Carbon ::parse(request() -> date_of_change) -> toDateString();
        $leaseFlowsDeleted = LeaseFlowService ::deleteLeaseFlow($this -> lease -> id, $dateOfChange);
        return $this;
    }

    function updateDepreciation()
    {
        return 1;
    }

    function updateLiability()
    {
    }

    function getLeaseFlows()
    {
        $leaseFlows = LeaseFlowService ::leaseFlowsNoDepreciation($this -> lease, $this -> extensionId);
        return $leaseFlows;
    }

    function changeInAsset($lastFlow, $leaseExtension)
    {
        $oldDepreciation = $this -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        return $oldDepreciation;
    }

    public function updateConversionRate()
    {
        $leaseExtension = LeaseExtension ::findOrFail($this -> extensionId);
        $previousExtension = LeaseExtensionService ::earlierExtension($this -> extensionId);
        $leaseExtension -> liability_conversion_rate = CurrencyConversion ::getRate(request('date_of_change'), $this -> lease -> entity -> currency, $this -> lease -> currency);
        $leaseExtension -> depreciation_conversion_rate = $previousExtension -> depreciation_conversion_rate;
        $leaseExtension -> save();
    }

}