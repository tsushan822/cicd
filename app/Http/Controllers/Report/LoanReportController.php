<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Rules\Common\ReportId;
use App\Zen\MmDeal\Model\Instrument;
use App\Zen\MmDeal\Model\MmDeal;
use App\Zen\Report\Generate\Loan\AccruedInterest\AccruedInterest;
use App\Zen\Report\Generate\Loan\BreakDown\BreakDownReport;
use App\Zen\Report\Generate\Loan\HistoricCashFlow;
use App\Zen\Report\Generate\Loan\InterestReport;
use App\Zen\Report\Generate\Loan\LoanTransactionReport;
use App\Zen\Report\Generate\Loan\LoanDurationReport;
use App\Zen\Report\Generate\Loan\LoanLimitReport;
use App\Zen\Report\Generate\Loan\LoanMonthEndReport;
use App\Zen\Report\Generate\Loan\LoanValuationReport;
use App\Zen\Report\Generate\Loan\NotesMaturityLoan;
use App\Zen\Report\Library\Loan\LoanReport;
use App\Zen\Report\Model\LoanReportRepository;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class LoanReportController extends Controller
{
    /**
     * @var LoanReportRepository
     */
    private $loanReportRepository;

    /**
     * LoanReportController constructor.
     * @param LoanReportRepository $loanReportRepository
     */
    public function __construct(LoanReportRepository $loanReportRepository)
    {
        $this -> middleware('module:Loan');
        $this -> loanReportRepository = $loanReportRepository;
    }

    public function index()
    {
        $this -> checkAllowAccess('can_view');
        return view('reports.internal-loans');
    }

    public function result(Request $request)
    {
        $baseCurrency = CurrencyService ::getCompanyBaseCurrency();
        $request -> validate(['accounting_date' => 'date|required']);
        $this -> checkAllowAccess('can_view');
        $accountingDate = $request -> accounting_date;

        $mmDeals = Mmdeal ::where('maturity_date', '>', $accountingDate) -> where('is_mirror_deal', 0)
            -> where('effective_date', '<', $accountingDate) -> with('instrument') -> with('dealFlow')
            -> with('counterparty') -> get();

        for($i = 0; $i < count($mmDeals); $i++) {
            if($mmDeals[$i] -> counterparty -> is_external == 0) {
                unset($mmDeals[$i]);
            }
        }

        foreach($mmDeals as $mmDeal) {
            $mmDeal -> notional_currency_amount_current = getCurrentNominalAmount($mmDeal, $accountingDate, $mmDeal -> dealflow);
            $mmDeal -> notional_amount_in_base_currency = CurrencyConversion ::currencyAmountToBaseAmount($mmDeal -> notional_currency_amount_current, $accountingDate, $baseCurrency, $mmDeal -> currency);
        }

        //convert date so that it can be used in view as a text string
        $dateString = date_create($accountingDate) -> format('jS \o\f F Y');
        return view('reports.internal-loans.result', compact('mmDeals', 'dateString'));

    }

    public function accruedIndex($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.accrued-excel', compact('instruments', 'entities', 'portfolios',
            'costCenters', 'counterparties', 'currencies', 'view'));
    }

    public function notesMaturity($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.notes-maturity', compact('instruments', 'entities', 'portfolios',
            'costCenters', 'counterparties', 'currencies', 'view'));
    }

    public function transactionLoan(int $reportLibraryId = null): View
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.transaction', compact('instruments', 'entities', 'portfolios',
            'costCenters', 'counterparties', 'currencies', 'view'));
    }

    public function postTransactionLoan(Request $request)
    {
        $this -> validationRulesStartEndDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                list($startDate, $endDate, $dealFlowsForStartEnd, $userData) = (new LoanTransactionReport()) -> generateReport($request -> start_date, $request -> end_date);
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.transaction', compact('userData', 'startDate', 'endDate',
                    'dealFlowsForStartEnd', 'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $returnLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'start_date', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.transaction')
                    -> setReportName('Loan Transaction Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.transaction', $returnLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function postNotesMaturity(Request $request)
    {
        $request -> validate([
            'end_date' => 'required|date',
            'mm_deal_id' => 'numeric| nullable',
            'currency_id' => 'required',
        ], [
            'end_date.required' => 'The report date is required.',
        ]);
        switch($request -> input('submit')){
            case 'submit':
                list($returnData, $startDate) = (new NotesMaturityLoan()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.notes-maturity', compact('returnData', 'startDate',
                    'instruments', 'entities', 'portfolios', 'currencies', 'view', 'costCenters', 'counterparties'));
            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'portfolio_id', 'lease_type_id', 'cost_center_id', 'end_date', 'currency_id', 'counterparty_id'])
                    -> makeModule('Loan')
                    -> setRoute('notes.maturity.loan')
                    -> setReportName('Notes Maturity Loan')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('notes.maturity.loan', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }

    }

    public function accruedReport(Request $request)
    {
        $this -> validate($request, ['end_date' => 'required | date'], ['end_date.required' => 'The report date is required']);

        $filter = "Portfolio";
        if($request -> report_grouping == 1) {
            $filter = "Instrument";
        }

        switch($request -> input('submit')){
            case 'submit':
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                list($returnData, $currency, $calculationDate) = AccruedInterest ::getReportData($request);
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.accrued-excel', compact('instruments', 'entities', 'portfolios',
                    'returnData', 'calculationDate', 'costCenters', 'filter', 'counterparties', 'currencies', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'end_date', 'report_grouping'])
                    -> makeModule('Loan')
                    -> setRoute('accrued.loan.excel')
                    -> setReportName('Accrued Interest Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('accrued.loan.excel', $reportLibrary -> id);


            default:
                return back();

        }
    }

    public function loanBreakDown($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.breakdown', compact('instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

    }

    public function downloadLoanBreakDown(Request $request)
    {
        $this -> validationRulesStartEndDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($startDate, $endDate, $startDateOfFinancialYear, $allMmDeals, $totalData) = (new BreakDownReport()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.breakdown', compact('startDate', 'endDate', 'startDateOfFinancialYear',
                    'entities', 'allMmDeals', 'view', 'instruments', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'totalData'));
            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'start_date', 'currency_id', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.breakdown')
                    -> setReportName('Loan BreakDown')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.breakdown', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function monthEndReport($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.month-end-report', compact('instruments', 'entities', 'portfolios',
            'currencies', 'costCenters', 'counterparties', 'view'));
    }

    public function postMonthEndReport(Request $request)
    {
        $this -> validationRulesOnlyReportDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($date, $mmDeals, $userData) = (new LoanMonthEndReport()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.month-end-report', compact('userData', 'date', 'mmDeals',
                    'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.month-end-report')
                    -> setReportName('Loan Month End Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.month-end-report', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function loanDurationReport($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.loan-duration-report', compact('instruments', 'entities', 'portfolios',
            'currencies', 'costCenters', 'counterparties', 'view'));
    }

    public function postLoanDurationReport(Request $request)
    {
        $this -> validationRulesOnlyReportDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($date, $mmDeals, $addInterestFlowFor) = (new LoanDurationReport()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                if(count($addInterestFlowFor)) {
                    flash() -> overlay(trans('master.Please add interest flow for the loan', ['loan' => implode(",", $addInterestFlowFor)])) -> message();
                }
                return view('reports.loans.loan-duration-report', compact('date', 'mmDeals',
                    'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.duration')
                    -> setReportName('Loan Duration Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.duration', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function loanLimitReport($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.loan-limit-report', compact('instruments', 'entities', 'portfolios',
            'currencies', 'costCenters', 'counterparties', 'view'));
    }

    public function postLoanLimitReport(Request $request)
    {
        $this -> validationRulesOnlyReportDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($reportDate, $returnValues) = (new LoanLimitReport()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.loan-limit-report', compact('reportDate',
                    'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view', 'returnValues'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);
                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.limit')
                    -> setReportName('Loan Limit Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.limit', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function loanValuationReport($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.loan-valuation-report', compact('instruments', 'entities', 'portfolios',
            'currencies', 'costCenters', 'counterparties', 'view'));
    }

    public function postLoanValuationReport(Request $request)
    {
        $this -> validationRulesOnlyReportDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($date, $mmDeals, $userData) = (new LoanValuationReport()) -> generateReport();
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.loan-valuation-report', compact('userData', 'date', 'mmDeals',
                    'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $reportLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.loan-valuation-report')
                    -> setReportName('Loan Valuation Report')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.loan-valuation-report', $reportLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function historicCashflow($reportLibraryId = null)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        $view = $this -> loanReportRepository -> insertCriteria($reportLibraryId);
        return view('reports.loans.historic_cashflow', compact('instruments', 'entities', 'portfolios',
            'currencies', 'costCenters', 'counterparties', 'view'));
    }

    public function historicCashflowTable(Request $request)
    {
        $this -> validationRulesStartEndDate($request);

        switch($request -> input('submit')){
            case 'submit':
                list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
                list($startDate, $endDate, $dealFlowsForStartEnd, $userData) = (new HistoricCashFlow()) -> generateReport($request -> start_date, $request -> end_date);
                $view = $this -> loanReportRepository -> insertCriteria();
                return view('reports.loans.historic_cashflow', compact('userData', 'startDate', 'endDate',
                    'dealFlowsForStartEnd', 'instruments', 'entities', 'portfolios', 'currencies', 'costCenters', 'counterparties', 'view'));

            case 'save':
                $request -> validate(['custom_report_name' => $this -> reportValidationArray()]);

                $returnLibrary = (new LoanReport())
                    -> setUserId(Auth ::id())
                    -> setCustomReportName($request -> get('custom_report_name'))
                    -> makeCriteria(['entity_id', 'counterparty_id', 'portfolio_id', 'instrument_id', 'cost_center_id', 'currency_id', 'start_date', 'end_date'])
                    -> makeModule('Loan')
                    -> setRoute('loan.historic_cashflow')
                    -> setReportName('Historic Cash Flow')
                    -> saveReportCriteria();

                flash() -> overlay(trans('master.The report criteria has been saved!'), trans('master.Success!')) -> message();
                return redirect() -> route('loan.historic_cashflow', $returnLibrary -> id);
                break;

            default:
                return back();
                break;
        }
    }

    public function interest()
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        return view('reports.loans.interest-report', compact('entities', 'instruments', 'portfolios', 'currencies', 'costCenters', 'counterparties'));
    }

    public function interestReport(Request $request)
    {
        list($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties) = $this -> getCriteria();
        list($allMmDeals, $startDate) = (new InterestReport()) -> generateReport();
        return view('reports.loans.interest-report', compact('entities', 'instruments', 'allMmDeals', 'startDate', 'portfolios', 'currencies', 'costCenters', 'counterparties'));
    }

    public function getCriteria()
    {
        $instruments = Instrument :: get() -> pluck('instrument_name', 'id') -> toArray();
        asort($instruments);

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


        return array($entities, $portfolios, $instruments, $currencies, $costCenters, $counterparties);
    }

    public function validationRulesOnlyReportDate($request)
    {
        return $this -> validate($request, [
            'end_date' => 'required | date',
            'mm_deal_id' => $this -> IdValidation()
        ], [
            'end_date.required' => 'The report date is required',
            'mm_deal_id.numeric' => 'The loan id field must be numeric.'
        ]);
    }

    public function validationRulesStartEndDate($request)
    {
        return $this -> validate($request, [
            'start_date' => 'required | date',
            'end_date' => 'required | date | after:start_date',
            'mm_deal_id' => $this -> IdValidation()
        ], [
            'mm_deal_id.numeric' => 'The loan id field must be numeric.'
        ]);
    }

    public function IdValidation()
    {
        return ['numeric', 'nullable',new ReportId(new MmDeal())];
    }

}
