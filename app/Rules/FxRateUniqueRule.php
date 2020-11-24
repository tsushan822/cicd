<?php

namespace App\Rules;

use App\Zen\Setting\Model\FxRate;
use Illuminate\Contracts\Validation\Rule;

class FxRateUniqueRule implements Rule
{
    /**
     * @var
     */
    private $ccyBaseId;
    /**
     * @var
     */
    private $ccyCrossId;
    /**
     * @var
     */
    private $date;

    private $missing;

    /**
     * Create a new rule instance.
     * @param $ccyBaseId
     * @param $ccyCrossId
     * @param $date
     */
    public function __construct(int $ccyBaseId, int $ccyCrossId, string $date = null)
    {
        $this -> ccyBaseId = $ccyBaseId;
        $this -> ccyCrossId = $ccyCrossId;
        $this -> date = $date;
    }

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!$this -> date) {
            $this -> missing = true;
            return false;
        }
        $query = FxRate ::where('ccy_base_id', $this -> ccyBaseId) -> where('ccy_cross_id', $this -> ccyCrossId)
            -> where('date', $this -> date);
        if(is_numeric(request() -> segment(2)) && (request() -> segment(1) == 'fxrates')) {
            $query = $query -> where('id', '<>', request() -> segment(2));
        }
        $fxRate = $query -> get();
        $collection = collect($fxRate);
        if($collection -> isEmpty()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        if($this -> missing)
            return trans('master.The date field is missing');
        return 'The date, currency base and currency cross should be unique. Similar data already exists.';
    }
}
