<?php

namespace App\Http\Middleware;

use App\Transformers\RemoveCommaFromRequest;

class RemoveComma extends RemoveCommaFromRequest
{
    protected $except = ['password'];
}
