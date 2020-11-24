<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/10/2017
 * Time: 10.55
 */

namespace App\Repository\Eloquent;


interface RepositoryInterface
{
    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function getByAttributeAll($attribute, $value, $orderBy = 'id', $order = 'asc');

    public function getByAttributeAllSkipEncrypt($attribute, $value, $array_key, $array_value = 'id');

    public function getAllSkipEncrypt($array_key, $array_value);
}