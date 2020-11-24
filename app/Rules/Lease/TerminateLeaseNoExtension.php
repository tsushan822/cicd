<?php

namespace App\Rules\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use Illuminate\Contracts\Validation\Rule;

class TerminateLeaseNoExtension implements Rule
{
    /**
     * @var Lease
     */
    private $lease;

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
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $leaseExtension = LeaseExtension::where('lease_id',$this->lease->id)->orderBy('created_at','desc')->limit(1)->first();
        if($leaseExtension->lease_extension_type == 'Terminate Lease')
            return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The extension cannot be made for terminated lease.';
    }
}
