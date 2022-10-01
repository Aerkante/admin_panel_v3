<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected  $model;


    public function __construct($model = null)
    {
        $this->model = $model ? app($model) : null;
    }

    public function save($attributes, $id = null)
    {
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function list()
    {
        return $this->model->get();
    }

    public function delete($id)
    {
        $this->model = $this->model->find($id);
        return $this->model->delete();
    }

    public function fetch($filters)
    {
        $limit = $filters['limit'] ?? 20;
        $page = $filters['page'] ?? null;

        if ($limit) {
            return $this->paginate($page, $limit);
        }

        return $this->get();
    }

    public function paginate($page = 1, $limit = 20)
    {
        return $this->model->paginate($limit);
    }

    private function get()
    {
        return $this->model->get();
    }
}
