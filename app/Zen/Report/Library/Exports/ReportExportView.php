<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 10.39
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Library\DownloadCriteriaFromDatabase;
use App\Zen\Report\Model\ReportLibrary;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

abstract class ReportExportView extends ReportExport implements FromView, ShouldAutoSize, WithColumnFormatting
{

}