<?php

namespace App\Rules\Common;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ReportId implements Rule
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Create a new rule instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {

        $this -> model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = $this -> model ::get() -> pluck('id') -> toArray();
        return in_array($value, $data);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('master.ID number does not found');
    }
}
