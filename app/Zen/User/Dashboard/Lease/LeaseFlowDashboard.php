<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/05/2018
 * Time: 16.10
 */

namespace App\Zen\User\Dashboard\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Lease\Service\LeaseService;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class LeaseFlowDashboard
{

    public function getChartValue()
    {
        $today = Carbon ::today() -> toDateString();
        $leases = Lease ::refactorEntity() -> where('maturity_date', '<>', null) -> reportable() -> where('maturity_date', '>', $today) -> orderBy('maturity_date') -> limit(4)
            -> get();
        //list($assetSum, $liabilitySum) = $this -> getAssetAndLiabilityValue();
        $numberOfEachType = $this -> getLeaseTypeNumber();
        return array($leases, $numberOfEachType);
    }

    public function getAssetAndLiabilityValue()
    {
        $today = Carbon ::today() -> toDateString();
        $leaseIdArray = Lease ::where('effective_date', '<', $today) -> where('maturity_date', '>', $today) -> get() -> pluck('id');
        $assetSum = [];
        $liabilitySum = [];
        foreach($leaseIdArray as $leaseId) {
            $asset = LeaseFlow ::where('lease_id', $leaseId) -> where('end_date', '<', $today)
                -> orderBy('end_date', 'desc') -> limit(1) -> first();
            if($asset)
                $assetSum[] = $asset;

            $liability = LeaseFlow ::where('lease_id', $leaseId) -> where('end_date', '<', $today)
                -> orderBy('end_date', 'desc') -> limit(1) -> first();
            if($liability)
                $liabilitySum[] = $liability;
        }
        return array($assetSum, $liabilitySum);
    }

    public function getLeaseType()
    {
        $itemArray = ['Machinery', 'Vehicle', 'IT', 'Building', 'Other'];
        return $itemArray;
    }

    public function getLeaseTypeNumber()
    {
        $returnValue = [];
        $total = 0;
        $itemArray = $this -> getLeaseType();
        foreach($itemArray as $item) {
            $total = $total + count($this -> getOfType($item));
            $returnValue[$item] = $this -> getOfType($item);
        }
        $returnValue['total'] = $total;
        return $returnValue;
    }

    public function getOfType($item)
    {
        $leaseTypeCollection = LeaseType ::with('allLeases') -> where('lease_type_item', $item) -> get();
        $numberItems = new Collection();
        foreach($leaseTypeCollection as $leaseType) {
            $numberItems = $numberItems -> merge($leaseType -> allLeases);
        }
        return $numberItems;
    }

    public function assetLiabilityPerType()
    {
        $returnValue = [];
        $itemArray = $this -> getLeaseType();
        foreach($itemArray as $item) {
            $liabilityPerId = 0;
            $leaseTypeCollection = LeaseType ::where('lease_type_item', $item) -> get();
            foreach($leaseTypeCollection as $leaseType) {
                $liabilityPerId += $this -> getLiabilityValue($leaseType);
            }
            $returnValue[] = $liabilityPerId;
        }
        $labels = collect($itemArray);
        $data = collect($returnValue) -> map(function ($val) {
            return intval($val);
        });
        return compact('labels', 'data');
    }

    public function getLiabilityValue($leaseType = null, $dateToCalculate = null)
    {
        $leaseId = $leaseType -> leases() -> pluck('id') -> toArray();
        return LeaseService ::currentLiability($dateToCalculate, $leaseId)[0];
    }

    public static function maturityGraph()
    {

        $baseCurrency = Counterparty ::parent() -> currency;
        $graphStartDate = Carbon ::parse(request('range1')) -> toDateString();
        $graphTestDate = $graphStartDate;
        $graphEndDate = Carbon ::parse(request('range2')) -> addMonth() -> toDateString();
        do {
            $rangeHeader[] = Carbon ::parse($graphTestDate) -> format('m/Y');
            $accountingDate = Carbon ::parse($graphTestDate) -> lastOfMonth() -> toDateString();
            list($totalLiability) = LeaseService ::currentLiability($accountingDate);
            $leaseLiability[] = $totalLiability;
            $graphTestDate = Carbon ::parse($accountingDate) -> addMonths(2) -> toDateString();
        } while (Carbon ::parse($graphTestDate) -> toDateTimeString() <= $graphEndDate);


        $labels = [
            "Liabilities",
        ];
        $dataset = [
            $leaseLiability,
        ];
        $counterpartyCount = 4;
        return compact('rangeHeader', 'labels', 'dataset', 'baseCurrency', 'counterpartyCount', 'graphEndDate', 'graphStartDate');
    }

    public function liabilityPerLessor($dateToCalculate = null)
    {
        $returnValue = [];
        $labels = [];
        $lessors = Lease :: distinct() -> pluck('counterparty_id') -> toArray();
        foreach($lessors as $item) {
            $counterparty = Counterparty ::with('lessors') -> findOrFail($item);
            $labels[] = $counterparty -> short_name;
            $returnValue[] = $this -> getLiabilityValuePerLessor($counterparty, $dateToCalculate);
        }
        $labels = collect($labels);
        $data = collect($returnValue);
        return compact('labels', 'data');
    }

    public function getLiabilityValuePerLessor($lessor, $dateToCalculate = null)
    {
        $leaseId = $lessor -> lessors -> pluck('id') -> toArray();
        return LeaseService ::currentLiability($dateToCalculate, $leaseId)[0];
    }

    public static function getCurrency($entityId = null)
    {
        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

}