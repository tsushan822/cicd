<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Zen\Report\Service\CashFlowManagement\Trezone\TrezoneIntegrate;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Portfolio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth');
    }

    public function treZone()
    {

        list($entities, $portfolios, $costCenters, $counterparties, $modules) = $this -> getCriteria();
        return view('reports.trezone.index', compact('entities', 'portfolios', 'costCenters', 'counterparties', 'modules'));
    }

    public function treZoneGet(Request $request)
    {
        $this -> validate($request, [
            'start_date' => 'required | date',
            'end_date' => 'required | date',
            'module_id' => 'required ',
        ]);

        list($entities, $portfolios, $costCenters, $counterparties, $modules) = $this -> getCriteria();
        $startDate = Carbon ::parse($request -> get('start_date')) -> toDateString();
        $endDate = Carbon ::parse($request -> get('end_date')) -> toDateString();
        $returnValues = (new TrezoneIntegrate($startDate, $endDate)) -> getAllFlows();
        return view('reports.trezone.index', compact('returnValues','entities', 'portfolios', 'costCenters', 'counterparties', 'modules'));
    }

    public function getCriteria()
    {
        $returnModule = [];

        $modules = config('cashflow.trezone.modules');
        foreach($modules as $key => $value)
            $returnModule[$value] = $key;

        $entities = Counterparty ::allowedEntity() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($entities);

        $counterparties = Counterparty ::counterparty() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($counterparties);

        $portfolios = Portfolio ::get() -> pluck('name', 'id') -> toArray();
        asort($portfolios);

        $costCenters = CostCenter ::get() -> pluck('short_name', 'id') -> toArray();
        asort($costCenters);


        return array($entities, $portfolios, $costCenters, $counterparties, $returnModule);
    }
}
