<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 09/02/2018
 * Time: 16.08
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AdminNotify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'adminNotify';
    }
}