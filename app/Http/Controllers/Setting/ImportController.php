<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Zen\Setting\Features\Import\Validate\AccountValidate;
use App\Zen\Setting\Features\Import\Validate\CostCenterValidate;
use App\Zen\Setting\Features\Import\Validate\CounterpartyValidate;
use App\Zen\Setting\Features\Import\Validate\FxRateValidate;
use App\Zen\Setting\Features\Import\Validate\LeaseValidate;
use App\Zen\Setting\Features\Import\Validate\PortfolioValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{

    /**
     * ImportController constructor.
     */
    public function __construct()
    {
        $this -> middleware('auth');
    }

    public function index()
    {
        $files = ['Lease', 'Company', 'Account', 'Guarantee'];
        $returnArray = [];
        foreach($files as $file) {
            $returnArray[$file] = Storage ::disk('local') -> allFiles('Related Documents' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . $file);
        }

        return view('Setting.import.import', compact('returnArray'));
    }

    public function import($module, $item)
    {
        $files = ['Lease', 'Company', 'Account', 'Guarantee'];
        $returnArray = [];
        foreach($files as $file) {
            $returnArray[$file] = Storage ::disk('local') -> allFiles('Related Documents' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . $file);
        }

        return view('Setting.import.create', compact('returnArray', 'module', 'item'));
    }

    public function leaseCheck(Request $request)
    {
        if(request() -> file('lease_excel')) {
            $file = request() -> lease_excel;
            list($warning, $info)= (new LeaseValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
            $info = false;
        }
        return compact('warning','info');
    }

    public function accountCheck(Request $request)
    {
        if(request() -> file('account_excel')) {
            $file = request() -> account_excel;
            $warning = (new AccountValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
        }
        return compact('warning','info');
    }

    public function counterpartyCheck(Request $request)
    {
        if(request() -> file('company_excel')) {
            $file = request() -> company_excel;
            $warning = (new CounterpartyValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
        }
        return compact('warning','info');
    }

    public function fxrateCheck(Request $request)
    {
        if(request() -> file('fxrate_excel')) {
            $file = request() -> fxrate_excel;
            $warning = (new FxRateValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
        }
        return compact('warning','info');
    }

    public function portfolioCheck(Request $request)
    {
        if(request() -> file('portfolio_excel')) {
            $file = request() -> portfolio_excel;
            $warning = (new PortfolioValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
        }
        return compact('warning','info');
    }

    public function costcenterCheck(Request $request)
    {
        if(request() -> file('costcenter_excel')) {
            $file = request() -> costcenter_excel;
            $warning = (new CostCenterValidate()) -> validate($file);
            $info = ['The file is ready to upload.'];
        } else {
            $warning = false;
        }
        return compact('warning','info');
    }
}
