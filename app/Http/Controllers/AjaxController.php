<?php

namespace App\Http\Controllers;

use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Features\AuditTrail\CounterpartyAuditTrail;
use App\Zen\Setting\Features\AuditTrail\LeaseAuditTrail;
use App\Zen\Setting\Model\AuditTrail;
use App\Zen\Setting\Model\CostCenter;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function getAccountOnCurrency()
    {
        $input = \Request ::input('option');
        $currencyId = $input[0];
        //$entityId = $input[1];
        //add where entity id later
        $query = Account ::where('currency_id', $currencyId) -> get();
        return $query;
    }


    public function getCostcenterAllPortfolio()
    {
        return CostCenter ::all();
    }

    public function getUnrealisedItem()
    {
        $input = request() -> input('option');
        $moduleId = $input[0];
        switch($moduleId){
            case 1:
                return app('voucherItem') -> loanItem('Unrealised');

            case 2:
                return app('voucherItem') -> fxDeaItem('Unrealised');

            case 6:
                return app('voucherItem') -> leaseItem('Unrealised');
            default:
                break;
        }
    }

    public function getRealisedItem()
    {
        $input = request() -> input('option');
        $moduleId = $input[0];
        switch($moduleId){
            case 1:
                return app('voucherItem') -> loanItem();

            case 2:
                return app('voucherItem') -> fxDeaItem();

            case 6:
                return app('voucherItem') -> leaseItem();
            default:
                break;
        }
    }

    public function getAudit($model, $Id)
    {
        switch($model){
            case 'Lease':
                $changes = (new LeaseAuditTrail()) -> finalData($Id);
                break;

            case 'Counterparty':
                $changes = (new CounterpartyAuditTrail()) -> finalData($Id);
                break;
            default:
                $changes = [];
                break;

        }

        if(isset($changes)) {
            foreach($changes as $key => $value) {
                $dateTime = Carbon ::parse($value['time']);
                $changes[$key]['before'] = !is_numeric($value['before']) ? $value['before'] : mYFormat($value['before']);
                $changes[$key]['after'] = !is_numeric($value['after']) ? $value['after'] : mYFormat($value['after']);
                $changes[$key]['diff_for_humans'] = $dateTime -> diffForHumans();
                $changes[$key]['date_time'] = $dateTime -> toDateTimeString();
                $changes[$key]['time_zone'] = $dateTime -> getTimezone() -> getName();
            }

            return $changes;
        }
        return [];
    }

    public function newEnvironmentIsready()
    {
        return (AuditTrail ::where('model', 'Lease') -> where('event', 'created') -> count() > 4) ? 'ready' : 'notReady';
    }

}
