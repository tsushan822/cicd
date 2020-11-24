<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginInitialRequest;
use App\Rules\PasswordRule;
use App\Rules\User\CheckDomainWhenCreate;
use App\Zen\System\Model\Customer;
use App\Zen\System\Service\TeamService;
use Exception;
use Hyn\Tenancy\Models\Hostname;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['loginInitial', 'postLoginInitial','initialRegistration']);

        // $this->middleware('subscribed');

        // $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        return view('home');
    }

    public function welcome()
    {

        return view('welcome');
    }

    public function loginInitial()
    {
        if(auth()->user())
            return redirect()->route('leases');

        return view('auth.initial');
    }

    public function postLoginInitial(LoginInitialRequest $request)
    {
        $email = $request->input('email');
        try {
            $websiteId = TeamService::websiteFromEmail($email);
            $hostName = Hostname::where('website_id', $websiteId)->first();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['email' => trans("master.You have not signed up yet to LeaseAccounting.app")]);
        }

        return redirect()->away('http://' . ($hostName->fqdn) . '/login?email=' . $email);
    }

    public function redirectApp()
    {
        $team = auth()->user()->teams->first();
        $customer = Customer::where('team_id', $team->id)->first();
        $hostName = Hostname::where('website_id', $customer->website_id)->first();
        return redirect()->away('http://' . $hostName->fqdn);
    }
    public function redirectToMain()
    {
        return redirect('/main');
    }

    public function initialRegistration(Request $request){
        try {
            $request->validate([ 'team' => 'required|max:255',
                'name' => 'required|max:255',
                'email' => ['bail', 'required', 'email', 'max:255', new CheckDomainWhenCreate],
                'password' => ['string', 'confirmed', 'min :' . config('password_validation.min_length'), 'max :' . config('password_validation.max_length'), new PasswordRule()],
            ]);
            return response()->json([
                'status' => 'success',
                'msg'    => 'The form has been successfully submitted',
                'error'  => false
            ], 201);
        }
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'There was some error while processing the submitted data!',
                'errors' => $exception->errors(),
            ], 201);
        }
    }




}