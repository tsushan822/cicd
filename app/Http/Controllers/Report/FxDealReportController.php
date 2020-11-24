<?php

namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use App\Rules\Common\ReportId;
use App\Zen\FxDeal\Model\FxDeal;
use App\Zen\Report\Library\Exports\FX\FxReport;
use App\Zen\Report\Model\FxDealReportRepository as ReportRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FxDealReportController extends Controller
{
    /**
     * @var ReportRepo
     */
    private $reportRepo;

    /**
     * FxDealReportController constructor.
     * @param ReportRepo $reportRepo
     */
    public function __construct(ReportRepo $reportRepo)
    {
        $this -> reportRepo = $reportRepo;
        $this -> middleware('module:Foreign Exchange');
    }

    public function realisedFxDeal($reportLibraryId = null)
    {
        $this -> checkAllowAccess('can_view');
        list($entities, $portfolios, $fxTypes, $currencies, $costCenters, $counterparties) = $this -> reportRepo -> getCriteria();
        $view = $this -> reportRepo -> insertCriteria($reportLibraryId);
        return view('reports.fxdeals.realised', compact('entities', 'portfolios', 'fxTypes',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postRealisedFxDeal(Request $request)
    {
        $request -> validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fx_deal_id' => $this->IdValidation()
        ]);

        switch($request -> input('submit')){
            case 'submit':
                $this -> checkAllowAccess('can_view');
                list($entities, $portfolios, $fxTypes, $currencies, $costCenters, $counterparties) = $this -> reportRepo -> getCriteria();
                $fxDeals = $this -> reportRepo -> getRealisedReport();
                $startDate = $request -> start_date;
                $view = $this -> reportRepo -> insertCriteria();
                return view('reports.fxdeals.realised', compact('entities', 'portfolios', 'fxTypes',
                    'currencies', 'fxDeals', 'startDate', 'view', 'costCenters', 'counterparties'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new FxReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'fx_type_id', 'cost_center_id', 'start_date', 'currency_id', 'end_date', 'counterparty_id'])
                    -> makeModule('Foreign Exchange')
                    -> setRoute('fxdeal.realised.report')
                    -> setReportName('Realised FxDeal Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('fxdeal.realised.report', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function unRealisedFxDeal($reportLibraryId = null)
    {
        $this -> checkAllowAccess('can_view');
        list($entities, $portfolios, $fxTypes, $currencies, $costCenters, $counterparties) = $this -> reportRepo -> getCriteria();
        $view = $this -> reportRepo -> insertCriteria($reportLibraryId);
        return view('reports.fxdeals.unrealised', compact('entities', 'portfolios', 'fxTypes',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postUnRealisedFxDeal(Request $request)
    {
        $request -> validate([
            'end_date' => 'required|date',
            'fx_deal_id' => $this->IdValidation()
        ], ['end_date.required' => 'The report date is required']);

        switch($request -> input('submit')){
            case 'submit':
                $this -> checkAllowAccess('can_view');
                list($entities, $portfolios, $fxTypes, $currencies, $costCenters, $counterparties) = $this -> reportRepo -> getCriteria();
                $fxDeals = $this -> reportRepo -> getUnRealisedReport();
                $endDate = $request -> end_date;
                $view = $this -> reportRepo -> insertCriteria();
                return view('reports.fxdeals.unrealised', compact('entities', 'portfolios', 'fxTypes',
                    'currencies', 'fxDeals', 'endDate', 'view', 'costCenters', 'counterparties'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new FxReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'fx_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id'])
                    -> makeModule('Foreign Exchange')
                    -> setRoute('fxdeal.unrealised.report')
                    -> setReportName('Unrealised FxDeal Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('fxdeal.unrealised.report', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }

    }

    public function IdValidation()
    {
        return ['numeric', 'nullable',new ReportId(new FxDeal())];
    }
}
