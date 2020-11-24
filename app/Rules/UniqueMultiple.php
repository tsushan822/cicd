<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class UniqueMultiple implements Rule
{
    /**
     * @var Model
     */
    private $model;
    /**
     * @var array
     */
    private $columns;
    /**
     * @var
     */
    private $id;

    /**
     * Create a new rule instance.
     * @param Model $model
     * @param array $columns
     * @param $id
     */
    public function __construct(Model $model, $columns = [], $id = null)
    {
        $this -> model = $model;
        $this -> columns = $columns;
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
        $query = $this -> model;
        if($this -> id) {
            $query = $query -> where('id', '<>', $this -> id);
        }
        foreach($this -> columns as $column) {
            $query = $query -> where($column, request() -> get($column));
        }
        $data = $query -> get();
        return $data -> first() ? false : true;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The same data already exist.';
    }
}
