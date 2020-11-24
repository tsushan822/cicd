<?php


namespace App\Http\Controllers\System;


use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\TeamController;

class CustomTeamController extends TeamController
{
    /**
     * Get the team matching the given ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $teamId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $teamId)
    {
        $team = parent ::show($request, $teamId);

        $team -> custom_tax_rate = $team -> taxPercentage();

        return $team;
    }
}