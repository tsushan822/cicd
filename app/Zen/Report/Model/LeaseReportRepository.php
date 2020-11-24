<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 11.21
 */

namespace App\Zen\Report\Model;


use App\Zen\Report\Library\Lease\LeaseReport;
use Illuminate\Support\Facades\Auth;

class LeaseReportRepository
{
    public function saveToReportLibrary($request, $route, $reportName, $criteria = [])
    {
        $reportLibrary = (new LeaseReport())
            -> setUserId(Auth ::id())
            -> setCustomReportName($request -> get('custom_report_name'))
            -> makeCriteria($criteria)
            -> makeModule('Lease')
            -> setRoute($route)
            -> setReportName($reportName)
            -> saveReportCriteria();

        flash() -> overlay('The report criteria has been saved !!', 'Success !') -> message();
        return $reportLibrary;
    }

    public function insertCriteria($reportLibraryId = null)
    {
        $view = [
            "id" => request('id'),
            "entity_id" => request('entity_id'),
            "portfolio_id" => request('portfolio_id'),
            "lease_type_id" => request('lease_type_id'),
            "cost_center_id" => request('cost_center_id'),
            "start_date" => request('start_date'),
            "end_date" => request('end_date'),
            "currency_id" => request('currency_id'),
            "custom_report_name" => request('custom_report_name'),
            "counterparty_id" => request('counterparty_id'),
            "number_of_month" => request('number_of_month'),
        ];

        if($reportLibraryId) {
            $reportLibrary = ReportLibrary ::findOrFail($reportLibraryId);
            $view = array_merge($view, json_decode($reportLibrary -> criteria, true));
            $view["custom_report_name"] = $reportLibrary -> custom_report_name;
            $view["id"] = $reportLibrary -> id;
        }
        return $view;
    }
}