<?php


namespace App\Zen\Setting\Traits;


trait ReportValidation
{
    public function reportValidationArray()
    {
        return 'required|between:2,100|alpha_dash|unique:tenant.report_libraries,custom_report_name,' . request() -> input('report_library_id');
    }
}