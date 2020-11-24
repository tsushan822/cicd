<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 31/10/2017
 * Time: 13.54
 */

namespace App\Repository\Eloquent;


interface RepositoryControllerInterface
{
    public function getIndexViewData();
    public function getEditViewData($id);
    public function getCreateViewData();
    public function handleCreate($request);
    public function handleEdit($request, $id);
}