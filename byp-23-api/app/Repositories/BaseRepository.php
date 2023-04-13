<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return $this->model;
    }

    public function getAll($filterParams = [])
    {
        if (! empty($filterParams)) {
            $this->model = $this->model->where($filterParams);
        }

        return $this->model->get();
    }

    public function getAllWithPagination($count, $filterParams = [])
    {
        if (! empty($filterParams)) {
            $this->model = $this->model->where($filterParams);
        }

        return $this->model->paginate($count)->items();
    }

    public function getById($id)
    {
        return $this->model->findOrfail($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function firstOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function update(Model $model, $data)
    {
        $model->update($data);

        return $model;
    }

    public function checkExist($data)
    {
        return $this->model->where($data)->select('id')->first();
    }

    public function delete(Model $model)
    {
        $model->delete();
    }
}
