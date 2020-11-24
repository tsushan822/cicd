<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Zen\Report\Model\AuditTrailRepository;
use App\Zen\Setting\Features\AuditTrail\AuditTrailIdToData;
use App\Zen\Setting\Model\AuditTrail;
use App\Zen\User\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    use AuditTrailIdToData;
    /**
     * @var AuditTrailRepository
     */
    private $auditTrailRepository;

    /**
     * AuditTrailController constructor.
     * @param AuditTrailRepository $auditTrailRepository
     */
    public function __construct(AuditTrailRepository $auditTrailRepository)
    {
        $this -> auditTrailRepository = $auditTrailRepository;
    }

    public function index()
    {
        $auditTrails = AuditTrail ::all();
        $users = User ::get() -> pluck('name', 'id');
        return view('reports.audit-trails.report', compact('auditTrails', 'users'));
    }

    public function requestData(Request $request)
    {
        $request -> validate([
            'accounting_start_date' => 'bail|date|required',
            'accounting_end_date' => ['bail', 'date', 'required', 'after:accounting_start_date', 'before_or_equal:' . Carbon ::parse($request -> accounting_start_date) -> addMonth() -> toDateString()],
        ], [
            'accounting_end_date.before_or_equal' => 'The maximum date is a month.',
        ]);
        $startDate = Carbon ::parse($request -> accounting_start_date) -> toDateString();

        $endDate = Carbon ::parse($request -> accounting_end_date) -> toDateString();

        $auditTrails = $this -> auditTrailRepository -> auditTrailQuery($startDate, $endDate, $request);

        $changes = $this -> auditTrailRepository -> getFinalData($auditTrails);

        $users = User ::get() -> pluck('name', 'id');

        return view('reports.audit-trails.report', compact('changes', 'users', 'startDate'));
    }

    /**
     * @param $result
     * @param $auditTrail
     * @return mixed
     */
    public function addTableIdAndModel($result, $auditTrail)
    {
        array_walk($result, function (&$value, $key) use ($auditTrail) {
            $value['table_id'] = $auditTrail['key'];
            $value['model'] = $this -> modifyModelName($auditTrail['model']);
        });
        return $result;
    }
}
