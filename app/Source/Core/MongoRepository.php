<?php

namespace BByer\Source\Core;


use BByer\Source\Core\Exceptions\EntityNotFoundException;
use Jenssegers\Mongodb\Model;

abstract class MongoRepository
{

    /**
     * @var \Jenssegers\Mongodb\Model;
     */
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllPaginated($count)
    {
//        return $this->model->paginate($count);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function requireById($id)
    {
        $model = $this->getById($id);

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }

    public function getNew($attributes = array ())
    {
        return $this->model->newInstance($attributes);
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeMongoModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    public function delete($model)
    {
        return $model->delete();
    }

    protected function storeMongoModel($model)
    {
//        $model->touch();
            return $model->save();
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);

        return $this->storeMongoModel($model);
    }
}