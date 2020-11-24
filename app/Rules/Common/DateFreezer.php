<?php

namespace App\Rules\Common;

use App\Zen\Setting\Model\AdminSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateFreezer implements Rule
{
    protected $dateFreeze;
    /**
     * @var null
     */
    private $checkDate;

    public function __construct($checkDate = null)
    {
        $this -> dateFreeze = today();
        $this -> checkDate = $checkDate;
    }

    /**
     * Determine if the validation rule passes.
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!$this -> checkDate)
            $this -> checkDate = $value;

        if(!$this -> checkIfDateFreezeActive()) {
            return true;
        }

        if(!$this -> checkDate) {
            return true;
        }

        if(Carbon ::parse($this -> checkDate) -> lessThanOrEqualTo($this -> dateFreeze)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return trans('master.date freeze validation', ['date' => $this -> dateFreeze -> toDateString()]);
    }

    public function checkIfDateFreezeActive()
    {
        $adminSetting = AdminSetting ::first();
        if(!$adminSetting instanceof AdminSetting)
            return false;

        $this -> dateFreeze = Carbon ::parse($adminSetting -> freezer_date);
        return $adminSetting -> date_freezer_active;

    }
}
