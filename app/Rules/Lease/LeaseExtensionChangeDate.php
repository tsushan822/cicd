<?php

namespace App\Rules\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class LeaseExtensionChangeDate implements Rule
{
    /**
     * @var Lease
     */
    private $lease;
    private $putDate = null;
    /**
     * @var
     */
    private $dateOfChange;

    /**
     * Create a new rule instance.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        $this -> lease = $lease;
    }

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $lastExtension = LeaseExtensionService ::lastExtension($this -> lease);
        $leaseFlows = LeaseFlowService ::leaseFlowsAll($this -> lease, $lastExtension -> id);
        for($i = 0; $i < count($leaseFlows); $i++) {
            $nextDay = addADay($leaseFlows[$i] -> end_date);
            if($value == $nextDay) {
                return true;
            }
            if($nextDay > $value) {
                $this -> putDate = addADay($leaseFlows[$i - 1] -> end_date);
                break;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.lease extension change message', ['date' => $this -> putDate]);
    }
}
