<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\PortfolioDataTable;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StorePortfolioRequest;
use App\Zen\Setting\Features\Import\Upload\PortfolioImport;
use App\Zen\Setting\Model\PortfolioRepository as PortfolioRepo;
use App\Zen\Setting\Service\ImportService;
use Illuminate\Http\Request;
use Laravel\Spark\Announcement;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class PortfolioController extends Controller
{
    /**
     * @var PortfolioRepo
     */
    private $portfolioRepo;

    /**
     * PortfolioController constructor.
     * @param PortfolioRepo $portfolioRepo
     */
    public function __construct(PortfolioRepo $portfolioRepo)
    {
        $this -> portfolioRepo = $portfolioRepo;
    }

    /**
     * Display a listing of the resource.
     * @param PortfolioDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(PortfolioDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.portfolios.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this -> checkAllowAccess('create_portfolio');
        return view('Setting.portfolios.create');
    }

    /**
     * @param StorePortfolioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePortfolioRequest $request)
    {
        $this -> checkAllowAccess('create_portfolio');
        $this -> portfolioRepo -> handleCreate($request);
        return redirect() -> route('portfolios.index') -> with('flash_message', 'Portfolio added!');
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('can_view');
        $portfolio = $this -> portfolioRepo -> getEditViewData($id);
        return view('Setting.portfolios.edit', compact('portfolio'));
    }

    /**
     * @param StorePortfolioRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePortfolioRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_portfolio');
        $this -> portfolioRepo -> handleEdit($request, $id);
        flash() -> overlay(trans('master.Portfolio updated!'), trans('master.Success!'));
        return redirect() -> route('portfolios.edit', [$id]);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this -> checkAllowAccess('delete_portfolio');
        $portfolio = $this -> portfolioRepo -> find($id);
        return view('Setting.portfolios.delete', compact('portfolio'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_portfolio');
        if($this -> portfolioRepo -> checkDeletable($id))
            throw new CustomException(trans('master.This portfolio can\'t be deleted as it has leases associated with it'));

        $this -> portfolioRepo -> find($id) -> delete();
        flash() -> overlay(trans('master.Portfolio deleted!'), trans('master.Deleted!'));
        return redirect() -> route('portfolios.index');
    }

    /**
     * @param $portfolioId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copy($portfolioId)
    {
        $this -> checkAllowAccess('create_portfolio');
        $portfolio = $this -> portfolioRepo -> getEditViewData($portfolioId);
        return view('Setting.portfolios.copy', compact('portfolio'));
    }


    /*public function importPost()
    {
        set_time_limit(20000);

        $this -> checkAllowAccess('import_portfolio');

        $this -> portfolioRepo -> handleImport();

        return back();
    }*/

    public function importPost(Request $request)
    {
        $this -> checkAllowAccess('import_portfolio');
        list($path, $importFile) = ImportService ::importService($request -> file('portfolio_excel'),'Import/Portfolio');
        Excel ::queueImport(new PortfolioImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        flash() -> overlay(trans('master.Your excel will be imported!',['file' => 'portfolio']), trans('master.Success!')) -> message();
        return back();
    }

    public function setupPost(StorePortfolioRequest $request)
    {
       // $this -> checkAllowAccess('create_portfolio');
        $this -> portfolioRepo -> handleCreate($request);
        return  1;

    }
}
