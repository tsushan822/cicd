<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 28/12/2017
 * Time: 11.42
 */

namespace App\Zen\Setting\Model;

use App\Repository\Eloquent\Repository;

class CountryRepository extends Repository
{

    /**
     * Specify Model class name
     * @return mixed
     */
    public function model()
    {
        return Country::class;
    }
}