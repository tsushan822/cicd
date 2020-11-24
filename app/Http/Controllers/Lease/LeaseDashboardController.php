<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/05/2018
 * Time: 16.02
 */

namespace App\Http\Controllers\Lease;

use App\Http\Controllers\Controller;
use App\Zen\Setting\Model\AuditTrail;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\User\Dashboard\LeaseMaturity;
use App\Zen\User\Dashboard\Lease\LeaseFlowDashboard;

class LeaseDashboardController extends Controller
{

    public function index()
    {
        list($default, $rangeMonths, $labels) = (new LeaseMaturity()) -> getChartValue();
        $returnValue['default'] = $default;
        $returnValue['rangeMonths'] = $rangeMonths;
        $returnValue['labels'] = $labels;
        $currency = Counterparty ::parent() -> currency;
        $environmentIsReady=(AuditTrail::where('model','=','Lease')->count()>5)? true : false;

        list($leases, $numberOfEachType) = (new LeaseFlowDashboard) -> getChartValue();
        return view('Dashboards.leases', compact('leases', 'numberOfEachType', 'returnValue', 'currency', 'environmentIsReady'));
    }
}