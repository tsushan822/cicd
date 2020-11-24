<?php

namespace App\Rules;

use App\Zen\Setting\Model\Counterparty;
use Illuminate\Contracts\Validation\Rule;

class UniqueCheckEncrypted implements Rule
{
    /**
     * @var
     */
    private $model;
    /**
     * @var null
     */
    private $id;

    /**
     * Create a new rule instance.
     * @param $model
     * @param null $id
     */
    public function __construct($model, $id = null)
    {
        $this -> model = $model;
        $this -> id = $id;
    }

    /**
     * Determine if the validation rule passes.
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this -> id) {
            $data = $this -> model ::get() -> where('id', '<>', $this -> id) -> pluck($attribute, 'id') -> toArray();
            return array_search($value, $data) ? false : true;
        }
        $data = $this -> model ::get() -> pluck($attribute) -> toArray();
        return in_array($value, $data) ? false : true;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The :attribute already existed for another item in the database.';
    }
}
