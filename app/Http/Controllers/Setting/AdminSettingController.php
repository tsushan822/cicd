<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Zen\Setting\Service\DataBondService;
use App\Zen\System\Model\Customer;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\System\Model\FxRateSource;
use App\Zen\User\Service\PasswordRegex;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class AdminSettingController extends Controller
{
    use PasswordRegex;

    public function __construct()
    {
        //$this -> middleware('checkAdmin');
    }

    public function index()
    {
        $this -> checkAllowAccess('can_view');
        $adminSetting = AdminSetting ::first();
        if(!$adminSetting instanceof AdminSetting) {
            $adminSetting = new AdminSetting();
            $adminSetting -> freezer_date = null;
            $adminSetting -> date_freezer_active = null;
            $adminSetting -> auth_log = null;
            $adminSetting -> number_of_unsuccessful_login = config('password_validation.number_of_unsuccessful_login');
            $adminSetting -> min_password_length = config('password_validation.min_length');
            $adminSetting -> max_password_length = config('password_validation.max_length');
            $adminSetting -> enable_change_password = config('password_validation.enable_change_password');
            $adminSetting -> password_change_days = config('password_validation.password_change_days');
            $adminSetting -> enable_failed_login_lock = config('password_validation.enable_failed_login_lock');
            $adminSetting -> enable_cost_center_split = null;
        }
        $returnValues = $this -> passwordRuleValue();
        $dataBondSources = config('rate.fx_source');
        $customer = Customer ::where('website_id', config('website_id')) -> first();
        $dataBondRateImport = true;
        $dataBondRateId = $customer -> fx_rate_source;
        return view('Setting.admin-settings.index', compact('adminSetting', 'returnValues', 'dataBondSources', 'dataBondRateImport', 'dataBondRateId'));

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        $this -> validate($request,
            ['freezer_date' => 'required_unless:date_freezer_active,0', 'min_password_length' => ['required', 'numeric', 'min:4']],
            ['freezer_date.required_unless' => trans('master.The freeze period date is required.')]
        );

        $adminSetting = AdminSetting ::first();
        $pattern = $this -> passwordRuleFormation($request);
        $request -> request -> add(['user_id' => \auth() -> id()]);
        $request -> request -> add(['password_criteria' => $pattern]);

        $dataBondSourceId = $request -> input('databond_source');

        $this -> updateRateSource($dataBondSourceId);

        if(!$adminSetting instanceof AdminSetting) {
            AdminSetting ::create($request -> all());
        } else {
            $adminSetting -> update($request -> all());
        }

        return redirect() -> route('admin-settings.index');
    }

    public function passwordRuleFormation($request)
    {
        $pas = '/^';
        if($request -> one_small) {
            $pas = $pas . '(?=.*[a-z])';
        }
        if($request -> one_capital) {
            $pas = $pas . '(?=.*[A-Z])';
        }
        if($request -> one_number) {
            $pas = $pas . '(?=.*\d)';
        }
        if($request -> one_special) {
            $pas = $pas . '(?=.*(_|[^\w]))';
        }
        $pas = $pas . '.+$/';
        return $pas;
    }

    public function updateRateSource($id)
    {
        $customer = Customer ::where('website_id', config('website_id')) -> first();
        $customer -> fx_rate_source = $id;
        $customer -> update();

    }

}
