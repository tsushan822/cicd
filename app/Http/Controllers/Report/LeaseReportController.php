<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 9.45
 */

namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use App\Http\Middleware\FacilityOverviewReport;
use App\Http\Middleware\LeaseYTDReport;
use App\Rules\Common\ReportId;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Report\Generate\Lease\AdditionLeaseLiability;
use App\Zen\Report\Generate\Lease\AdditionROUAsset;
use App\Zen\Report\Generate\Lease\LeaseChangeReport;
use App\Zen\Report\Generate\Lease\LeaseFacilityOverviewReport;
use App\Zen\Report\Generate\Lease\LeasePaymentReport;
use App\Zen\Report\Generate\Lease\LeaseMonthValue;
use App\Zen\Report\Generate\Lease\LeaseSummaryReport;
use App\Zen\Report\Generate\Lease\LeaseSummaryReportYTD;
use App\Zen\Report\Generate\Lease\LeaseValuationReport;
use App\Zen\Report\Generate\Lease\NotesMaturityTable;
use App\Zen\Report\Generate\Lease\NotesPeriodicalDepreciation;
use App\Zen\Report\Generate\Lease\RoUAssetByLeaseType;
use App\Zen\Report\Library\Lease\LeaseReport;
use App\Zen\Report\Model\LeaseReportRepository;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaseReportController extends Controller
{
    /**
     * @var LeaseReportRepository
     */
    private $repository;

    /**
     * LeaseReportController constructor.
     * @param LeaseReportRepository $repository
     */
    public function __construct(LeaseReportRepository $repository)
    {
        $this->middleware('module:Lease');
        $this->middleware(FacilityOverviewReport::class)->only(['facilityOverview','postFacilityOverview']);
        $this->middleware(LeaseYTDReport::class)->only(['leaseSummaryYTD','postLeaseSummaryYTD']);
        $this->repository = $repository;
    }

    public function index()
    {
        return view('reports.lease.internal-lease');
    }


    public function internalLease()
    {
        return view('reports.lease.internal-lease');
    }

    public function postInternalLease()
    {
        return view('reports.lease.internal-lease');
    }

    public function notesMaturity($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        $currency = 1;
        return view('reports.lease.notes-maturity', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties', 'currency'));
    }

    public function postNotesMaturity(Request $request)
    {
        $request->validate([
            'end_date' => 'required|date',
            'lease_id' => $this->IdValidation(),
            'currency_id' => 'required',
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request->input('submitButton')){
            case 'submit':
                list($returnData, $startDate) = (new NotesMaturityTable())->generateReport();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $view = $this->repository->insertCriteria();
                return view('reports.lease.notes-maturity', compact('returnData', 'startDate',
                    'leaseTypes', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));
            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $reportLibrary = (new LeaseReport())
                    ->setUserId(Auth::id())
                    ->setCustomReportName($request->get('custom_report_name'))
                    ->makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    ->makeModule('Lease')
                    ->setRoute('reporting.notes-maturity')
                    ->setReportName('Notes Maturity Report')
                    ->saveReportCriteria();

                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('reporting.notes-maturity', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }

    }

    public function leaseValuation($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.lease-valuation', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postLeaseValuation(Request $request)
    {
        $request->validate([
            'end_date' => 'required|date',
            'lease_id' => $this->IdValidation(),
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request->input('submitButton')){
            case 'submit':
                list($startDate, $returnData) = (new LeaseValuationReport())->generateReport();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $view = $this->repository->insertCriteria();
                return view('reports.lease.lease-valuation', compact('returnData', 'startDate',
                    'leaseTypes', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));
            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $reportLibrary = (new LeaseReport())
                    ->setUserId(Auth::id())
                    ->setCustomReportName($request->get('custom_report_name'))
                    ->makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    ->makeModule('Lease')
                    ->setRoute('lease.valuation')
                    ->setReportName('Lease Valuation Report')
                    ->saveReportCriteria();

                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.valuation', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }


    public function facilityOverview($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.facility-overview', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postFacilityOverview(Request $request)
    {

        $request->validate([
            'lease_id' => $this->IdValidation(),
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request->input('submitButton')){
            case 'submit':
                list($startDate, $returnData) = (new LeaseFacilityOverviewReport())->generateReport();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $view = $this->repository->insertCriteria();
                return view('reports.lease.facility-overview', compact('returnData', 'startDate',
                    'leaseTypes', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));
            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $reportLibrary = (new LeaseReport())
                    ->setUserId(Auth::id())
                    ->setCustomReportName($request->get('custom_report_name'))
                    ->makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    ->makeModule('Lease')
                    ->setRoute('reporting.facility-overview')
                    ->setReportName('Lease Facility Overview Report')
                    ->saveReportCriteria();

                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('reporting.facility-overview', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public
    function notesPeriodicalDepreciation()
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        return view('reports.lease.notes-periodical-depreciation', compact('leaseTypes', 'entities',
            'portfolios', 'currencies', 'costCenters', 'counterparties'));
    }

    public
    function postNotesPeriodicalDepreciation(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'lease_id' => $this->IdValidation()
        ]);
        $returnData = (new NotesPeriodicalDepreciation())->generateReport();
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $startDate = $request->start_date;
        return view('reports.lease.notes-periodical-depreciation', compact('returnData', 'startDate',
            'leaseTypes', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties'));

    }

    public
    function changeReportLease($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.change-lease', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public
    function postChangeReportLease(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'lease_id' => $this->IdValidation()
        ]);
        switch($request->input('submitButton')){
            case 'submit':
                $leaseFlows = (new LeaseChangeReport())->generateReport();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $view = $this->repository->insertCriteria();
                $startDate = $request->start_date;
                return view('reports.lease.change-lease', compact('leaseFlows', 'startDate',
                    'leaseTypes', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));
            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $reportLibrary = (new LeaseReport())
                    ->setUserId(Auth::id())
                    ->setCustomReportName($request->get('custom_report_name'))
                    ->makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'start_date',
                        'currency_id', 'end_date', 'counterparty_id'])
                    ->makeModule('Lease')
                    ->setRoute('reporting.change-lease')
                    ->setReportName('Lease Changes Report')
                    ->saveReportCriteria();
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('reporting.change-lease', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public
    function monthReportLease($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.month-payment', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public
    function postMonthReportLease(Request $request)
    {
        $request->validate([
            'start_date' => 'required | date',
            'end_date' => 'required | date | after:start_date',
            'lease_id' => $this->IdValidation()
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                $leaseFlows = (new LeasePaymentReport())->generateReport();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $startDate = $request->start_date;
                $view = $this->repository->insertCriteria();
                return view('reports.lease.month-payment', compact('leaseFlows', 'startDate',
                    'leaseTypes', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $reportLibrary = (new LeaseReport())
                    ->setUserId(Auth::id())
                    ->setCustomReportName($request->get('custom_report_name'))
                    ->makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'start_date',
                        'currency_id', 'end_date', 'counterparty_id'])
                    ->makeModule('Lease')
                    ->setRoute('reporting.month-payment')
                    ->setReportName('Lease Payments Report')
                    ->saveReportCriteria();
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('reporting.month-payment', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public
    function monthValue($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.month-value', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public
    function postMonthValue(Request $request)
    {
        $request->validate([
            'end_date' => 'required|date',
            'lease_id' => $this->IdValidation()
        ], ['end_date.required' => 'The report date is required']);

        switch($request->input('submitButton')){
            case 'submit':
                $leases = (new LeaseMonthValue())->generateReport();
                $view = $this->repository->insertCriteria();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $startDate = $request->end_date;
                return view('reports.lease.month-value', compact('leases', 'startDate', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);

                $route = 'reporting.month-value';
                $reportName = 'Lease Month End Value';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('reporting.month-value', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public function leaseSummary($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        $currency = 1;
        return view('reports.lease.lease-summary-report', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties', 'currency'));
    }

    public function postLeaseSummary(Request $request)
    {
        $request->validate([
            'end_date' => 'required | date',
            'number_of_month' => 'required | numeric',
            'lease_id' => $this->IdValidation(),
            'currency_id' => 'bail | required | numeric'
        ], [
            'end_date.required' => 'The report date is required',
            'currency_id.required' => 'The currency is required'
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                list($total, $dateHeader) = (new LeaseSummaryReport())->generateReport();
                $view = $this->repository->insertCriteria();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $startDate = $request->end_date;
                return view('reports.lease.lease-summary-report', compact('total', 'startDate', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties', 'dateHeader'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $route = 'lease.summary';
                $reportName = 'Lease Summary Report';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id', 'number_of_month'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.summary', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }


    public function leaseSummaryYTD($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.lease-summary-ytd-report', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postLeaseSummaryYTD(Request $request)
    {
        $request->validate([
            'end_date' => 'required | date',
            'start_date' => 'required | date',
            'lease_id' => $this->IdValidation(),
        ], [
            'end_date.required' => 'The report date is required',
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                list($total, $dateHeader) = (new LeaseSummaryReportYTD())->generateReport();
                $view = $this->repository->insertCriteria();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $startDate = $request->end_date;
                return view('reports.lease.lease-summary-ytd-report', compact('total', 'startDate', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties', 'dateHeader'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $route = 'lease.summary.ytd';
                $reportName = 'Lease Summary Report YTD';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'start_date', 'end_date', 'counterparty_id', 'number_of_month'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.summary.ytd', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public function rouAssetByType($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        $currency = 1;
        return view('reports.lease.rou-asset-leasetype-report', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties', 'currency'));
    }

    public function postRouAssetByType(Request $request)
    {
        $request->validate([
            'end_date' => 'required | date',
            'number_of_month' => 'required | numeric',
            'lease_id' => $this->IdValidation(),
            'currency_id' => 'bail | required | numeric'
        ], [
            'end_date.required' => 'The report date is required',
            'currency_id.required' => 'The currency is required'
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                list($total, $dateHeader) = (new RoUAssetByLeaseType())->generateReport();
                $view = $this->repository->insertCriteria();
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                $startDate = $request->end_date;
                return view('reports.lease.rou-asset-leasetype-report', compact('total', 'startDate', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties', 'dateHeader'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $route = 'lease.asset-lease-type';
                $reportName = 'RoU Asset by Lease Type';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id', 'number_of_month'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.asset-lease-type', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public function additionLeaseLiability($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.additions-lease-liability', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postAdditionLeaseLiability(Request $request)
    {
        $request->validate([
            'end_date' => 'required | date',
            'lease_id' => $this->IdValidation(),
            'currency_id' => 'bail | nullable | numeric'
        ], [
            'end_date.required' => 'The report date is required',
            'currency_id.required' => 'The currency is required'
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                $leases = (new AdditionLeaseLiability())->generateReport();
                $view = $this->repository->insertCriteria();
                $startDate = $request->end_date;
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                return view('reports.lease.additions-lease-liability', compact('leases', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties', 'startDate'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $route = 'lease.additions-lease-liability';
                $reportName = 'Addition Lease Liability';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id', 'number_of_month'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.additions-lease-liability', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public function rightAsset($reportLibraryId = null)
    {
        list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
        $view = $this->repository->insertCriteria($reportLibraryId);
        return view('reports.lease.additions-rou-asset', compact('leaseTypes', 'entities', 'portfolios',
            'currencies', 'view', 'costCenters', 'counterparties'));
    }

    public function postRightAsset(Request $request)
    {
        $request->validate([
            'end_date' => 'required | date',
            'lease_id' => $this->IdValidation(),
            'currency_id' => 'bail | nullable | numeric'
        ], [
            'end_date.required' => 'The report date is required',
            'currency_id.required' => 'The currency is required'
        ]);

        switch($request->input('submitButton')){
            case 'submit':
                $leases = (new AdditionROUAsset())->generateReport();
                $view = $this->repository->insertCriteria();
                $startDate = $request->end_date;
                list($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties) = $this->getCriteria();
                return view('reports.lease.additions-rou-asset', compact('leases', 'leaseTypes',
                    'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties', 'startDate'));

            case 'save':
                $request->validate(['custom_report_name' => $this->reportValidationArray()]);
                $route = 'lease.additions-lease-liability';
                $reportName = 'Addition ROU Asset';
                $criteria = ['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'currency_id', 'end_date', 'counterparty_id', 'number_of_month'];
                $reportLibrary = $this->repository->saveToReportLibrary($request, $route, $reportName, $criteria);
                $message = trans('master.The report criteria has been saved!');
                $redirectRoute = route('lease.additions-rou-asset', $reportLibrary->id);
                return compact('message', 'redirectRoute');
                break;

            default:
                return back();
                break;
        }
    }

    public
    function getCriteria()
    {
        $leaseTypes = LeaseType::get()->pluck('type', 'id')->toArray();
        asort($leaseTypes);

        $entities = Counterparty:: allowedEntity()->get()->pluck('short_name', 'id')->toArray();
        asort($entities);

        $counterparties = Counterparty::counterparty()->get()->pluck('short_name', 'id')->toArray();
        asort($counterparties);

        $portfolios = Portfolio::get()->pluck('name', 'id')->toArray();
        asort($portfolios);

        $currencies = Currency::active()->get()->pluck('iso_4217_code', 'id')->toArray();
        asort($currencies);

        $costCenters = CostCenter::get()->pluck('short_name', 'id')->toArray();
        asort($costCenters);

        return array($entities, $portfolios, $leaseTypes, $currencies, $costCenters, $counterparties);
    }

    public function IdValidation()
    {
        return ['numeric', 'nullable', new ReportId(new Lease())];
    }
}