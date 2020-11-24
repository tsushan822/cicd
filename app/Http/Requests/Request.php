<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function fileValidation()
    {
        return  'nullable|mimes:jpeg,bmp,png,jpg,xls,xlsx,pdf|max:5120';
    }
}
