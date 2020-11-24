<?php


namespace App\Http\Controllers\System;


use App\Zen\System\Model\Customer;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Settings\Teams\Billing\InvoiceController;
use Laravel\Spark\Spark;
use Laravel\Spark\Team;

class CustomInvoiceController extends InvoiceController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('auth');
    }

    /**
     * Get all of the invoices for the given team.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Laravel\Spark\Team $team
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, Team $team)
    {
        abort_unless($request -> user() -> ownsTeam($team), 403);

        if(!$team -> hasBillingProvider()) {
            return [];
        }

        return $team -> localInvoices;
    }

    /**
     * Download the invoice with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Laravel\Spark\Team $team
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, Team $team, $id)
    {
        abort_unless($request -> user() -> ownsTeam($team), 403);

        $invoice = $team -> localInvoices()
            -> where('id', $id) -> firstOrFail();

        return $team -> downloadInvoice(
            $invoice -> provider_id, ['id' => $invoice -> id] + Spark ::invoiceDataFor($team)
        );
    }
}