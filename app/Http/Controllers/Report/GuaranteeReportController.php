<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 31/05/2018
 * Time: 12.09
 */

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Rules\Common\ReportId;
use App\Zen\Guarantee\Model\Guarantee;
use App\Zen\Guarantee\Model\GuaranteeType;
use App\Zen\Report\Generate\Guarantee\GuaranteeLimitReport;
use App\Zen\Report\Generate\Guarantee\GuaranteePaymentReport;
use App\Zen\Report\Generate\Guarantee\GuaranteeReport;
use App\Zen\Report\Library\Guarantee\GuaranteeReport as GuaranteeReportLibrary;
use App\Zen\Report\Model\GuaranteeReportRepository;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuaranteeReportController extends Controller
{
    /**
     * @var GuaranteeReportRepository
     */
    private $repository;

    /**
     * GuaranteeReportController constructor.
     * @param GuaranteeReportRepository $repository
     */
    public function __construct(GuaranteeReportRepository $repository)
    {
        $this -> middleware('module:Guarantees');
        $this -> repository = $repository;
    }

    public function editCriteria($reportLibraryId)
    {
        list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
        $view = $this -> repository -> insertCriteria($reportLibraryId);
        return view('reports.guarantees.report', compact('guaranteeTypes', 'entities',
            'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
    }

    public function index()
    {
        list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
        $view = $this -> repository -> insertCriteria();
        return view('reports.guarantees.report', compact('guaranteeTypes', 'entities',
            'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
    }

    public function result(Request $request)
    {
        $request -> validate([
            'end_date' => 'required|date',
            'guarantee_id' =>  $this -> IdValidation(),
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request -> input('submit')){
            case 'show':
                list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
                list($reportDate, $guarantees) = (new GuaranteeReport()) -> generateReport();
                $view = $this -> repository -> insertCriteria();
                return view('reports.guarantees.report', compact('guaranteeTypes', 'entities', 'reportDate',
                    'guarantees', 'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
                break;

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new GuaranteeReportLibrary())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'guarantee_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    -> makeModule('Guarantees')
                    -> setRoute('report.guarantee')
                    -> setReportName('Guarantee Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();

                return redirect(route('report.guarantee', $reportLibrary -> id));

                break;

            default:
                return back();
                break;
        }
    }


    public function guaranteeLimit($reportLibraryId = null)
    {
        list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
        $view = $this -> repository -> insertCriteria($reportLibraryId);
        return view('reports.guarantees.limit', compact('guaranteeTypes', 'entities',
            'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \App\Exceptions\CurrencyConversionException
     * @throws \App\Exceptions\CustomException
     */
    public function postGuaranteeLimit(Request $request)
    {
        $request -> validate([
            'end_date' => 'required|date',
            'guarantee_id' =>  $this -> IdValidation(),
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request -> input('submit')){
            case 'show':
                list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
                list($reportDate, $guarantors) = (new GuaranteeLimitReport()) -> generateReport();
                $view = $this -> repository -> insertCriteria();
                return view('reports.guarantees.limit', compact('guaranteeTypes', 'entities', 'reportDate',
                    'guarantors', 'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
                break;

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new GuaranteeReportLibrary())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'guarantee_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    -> makeModule('Guarantees')
                    -> setRoute('report.guarantee-limit')
                    -> setReportName('Guarantee Limit Report')
                    -> saveReportCriteria();
                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect(route('report.guarantee-limit', $reportLibrary -> id));
                break;

            default:
                return back();
                break;
        }
    }

    public function guaranteePayment($reportLibraryId = null)
    {
        list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
        $view = $this -> repository -> insertCriteria($reportLibraryId);
        return view('reports.guarantees.payment', compact('guaranteeTypes', 'entities',
            'portfolios', 'costCenters', 'currencies', 'view', 'counterparties'));
    }

    public function postGuaranteePayment(Request $request)
    {
        $request -> validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'guarantee_id' => $this -> IdValidation(),
        ]);
        switch($request -> input('submit')){
            case 'show':
                list($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties) = $this -> selectCriteria();
                list($guaranteeFlows, $startDate) = (new GuaranteePaymentReport()) -> generateReport();
                $view = $this -> repository -> insertCriteria();
                return view('reports.guarantees.payment', compact('guaranteeTypes', 'entities',
                    'guaranteeFlows', 'portfolios', 'costCenters', 'currencies', 'view', 'counterparties', 'startDate'));
                break;

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new GuaranteeReportLibrary())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'guarantee_type_id', 'cost_center_id', 'end_date',
                        'start_date', 'currency_id', 'counterparty_id'])
                    -> makeModule('Guarantees')
                    -> setRoute('report.guarantee-payment')
                    -> setReportName('Guarantee Payment Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect(route('report.guarantee-payment', $reportLibrary -> id));
                break;

            default:
                return back();
                break;
        }
    }

    public function selectCriteria()
    {
        $guaranteeTypes = GuaranteeType ::get() -> pluck('guarantee_name', 'id') -> toArray();

        $entities = Counterparty ::allowedEntity() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($entities);

        $counterparties = Counterparty ::counterparty() -> get() -> pluck('short_name', 'id') -> toArray();
        asort($counterparties);

        $portfolios = Portfolio ::get() -> pluck('name', 'id') -> toArray();
        asort($portfolios);

        $currencies = Currency ::active() -> get() -> pluck('iso_4217_code', 'id') -> toArray();
        asort($currencies);

        $costCenters = CostCenter ::get() -> pluck('short_name', 'id') -> toArray();
        asort($costCenters);

        return array($guaranteeTypes, $portfolios, $entities, $costCenters, $currencies, $counterparties);
    }

    public function IdValidation()
    {
        return ['numeric', 'nullable', new ReportId(new Guarantee())];
    }
}