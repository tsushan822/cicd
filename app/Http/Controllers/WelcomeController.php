<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
        return view('spark_welcome');
    }
}
