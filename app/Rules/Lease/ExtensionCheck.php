<?php

namespace App\Rules\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseFlowService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class ExtensionCheck implements Rule
{
    /**
     * @var Lease
     */
    private $lease;
    private $lastFlow;
    private $checkDate;

    /**
     * Create a new rule instance.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        $this -> lease = $lease;
        $extensionStartDate = request() -> extension_start_date;
        $this -> lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $extensionStartDate);
        $this -> checkDate();

    }

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $extensionEndDate = request() -> extension_end_date;

        if($extensionEndDate < $this -> checkDate || !Carbon ::parse($extensionEndDate) -> endOfMonth() -> isSameDay(Carbon ::parse($extensionEndDate))) {
            return false;
        }
        return true;
    }

    public function checkDate()
    {
        $leaseFlowPerYear = $this -> lease -> lease_flow_per_year;
        if($this -> lastFlow instanceof LeaseFlow) {
            $this -> checkDate = Carbon ::parse($this -> lastFlow -> end_date) -> addMonths(12 / $leaseFlowPerYear) -> endOfMonth() -> toDateString();
        } else {
            $firstFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($this -> lease);
            $this -> checkDate = $firstFlow -> end_date;
        }

    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.The extension end date should be after and should be end of month',['date' =>  $this -> checkDate ]);
    }
}
