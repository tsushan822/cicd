<?php


namespace App\Zen\Report\Library\Exports;

use App\Zen\Report\Generate\Lease\AdditionLeaseLiability;
use App\Zen\Report\Generate\Lease\LeasePaymentReport;
use Illuminate\Contracts\View\View;

class AdditionLeaseLiabilityExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $leases = (new AdditionLeaseLiability()) -> generateReport();
        $startDate = request() -> end_date;
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.additions-lease-liability-table-report', compact('leases', 'startDate','criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
            'J' => $this -> numberFormat(),
            'K' => $this -> numberFormat(),
            'L' => $this -> numberFormat(),
            'M' => $this -> numberFormat(),
            'N' => $this -> numberFormat(),
            'O' => $this -> numberFormat(),
        ];
    }
}