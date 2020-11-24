<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Zen\Setting\Model\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alreadyAllocated = true;
        $dashboards = Auth ::user() -> dashboards() -> get();
        if(!count($dashboards))
        {
            $alreadyAllocated = false;
            $dashboards = Dashboard::all();
        }
        return view('Setting.dashboard.index', compact('dashboards','alreadyAllocated'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->all() as $item=>$value)
        {
            if($item != '_token'){
                $dashboard = Dashboard::find($item);
                $dashboard->users()->sync([Auth::id() => ['active_status' => $value == 'on' ? 1 :0]]);
            }
        }
        flash()->overlay('Dashboard Setting Saved !','Success !')->message();
        return redirect()->route('dashboard.index');
    }

}
