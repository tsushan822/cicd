<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/11/2017
 * Time: 14.15
 */

namespace App\Transformers;


use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class RemoveCommaFromRequest extends TransformsRequest
{
    protected $except = [];
    public function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        $b = str_replace( ',', '', $value );
        return is_numeric( $b ) ? $b : $value;
    }
}