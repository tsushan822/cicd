<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 13/03/2019
 * Time: 13.58
 */

namespace App\Zen\Report\Library\Exports;


use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

abstract class ReportExportQuery extends ReportExport implements FromQuery,WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
}