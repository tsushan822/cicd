<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/10/2017
 * Time: 11.03
 */

namespace App\Repository\Exception;


class RepositoryException extends \Exception
{

    /**
     * RepositoryException constructor.
     * @param string $string
     */
    public function __construct($string)
    {
        return $this -> getMessage();
    }
}