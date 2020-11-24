<?php namespace App\Repository\Eloquent;


use App\Repository\Exception\RepositoryException;
use App\Zen\User\Permission\AllowedEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as App;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface
{
    use AllowedEntity;
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @param App $app
     * @param Collection $collection
     * @throws RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this -> app = $app;
        $this -> criteria = $collection;
        $this -> resetScope();
        $this -> makeModel();
    }

    /**
     * Specify Model class name
     * @return mixed
     */
    public abstract function model();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        $this -> applyCriteria();
        return $this -> model -> get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 1, $columns = array('*'))
    {
        $this -> applyCriteria();
        return $this -> model -> paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this -> model -> create($data);
    }


    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this -> model -> where($attribute, '=', $id) -> update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this -> findOrFail($id) -> delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this -> model -> findOrFail($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        $this -> applyCriteria();
        return $this -> model -> find($id, $columns);
    }

    /**
     * @param $array1
     * @param $array2
     * @return mixed
     */
    public function updateOrCreate($array1, $array2)
    {
        return $this -> model -> updateOrCreate($array1, $array2);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        $this -> applyCriteria();
        return $this -> model -> where($attribute, '=', $value) -> first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param string $orderBy
     * @param string $order
     * @return mixed
     */
    public function getByAttributeAll($attribute, $value, $orderBy = 'id', $order = 'asc')
    {
        $this -> applyCriteria();
        return $this -> model -> where($attribute, '=', $value) -> orderBy($orderBy, $order) -> get();
    }

    /*public function getAll($array_key, $array_value = 'id') {
        $this->applyCriteria();
        $returnData = $this->all()-> pluck($array_value, $array_key)->toArray();
        asort($returnData);
        return $returnData;
    }*/

    public function getByAttributeAllSkipEncrypt($attribute, $value, $array_key, $array_value = 'id')
    {
        $this -> applyCriteria();
        $query = $this -> model -> where($attribute, '=', $value) -> get();
        $returnData = $query -> pluck($array_value, $array_key) -> toArray();
        asort($returnData);
        return $returnData;
    }

    public function getAllSkipEncrypt($array_key, $array_value = 'id')
    {
        $this -> applyCriteria();
        $query = $this -> all();
        $returnData = $query -> pluck($array_value, $array_key) -> toArray();
        asort($returnData);
        return $returnData;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this -> app -> make($this -> model());

        if(!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this -> model = $model -> newQuery();
    }

    /**
     * @return $this
     */
    public function resetScope()
    {
        $this -> skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this -> skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this -> criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this -> model = $criteria -> apply($this -> model, $this);
        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this -> criteria -> push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if($this -> skipCriteria === true)
            return $this;

        foreach($this -> getCriteria() as $criteria) {
            if($criteria instanceof Criteria)
                $this -> model = $criteria -> apply($this -> model, $this);
        }

        return $this;
    }
}