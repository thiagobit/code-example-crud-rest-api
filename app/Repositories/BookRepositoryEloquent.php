<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BookRepositoryEloquent implements BookRepositoryInterface
{
    public function __construct(protected Model $model)
    {}

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function all(int $pageSize = 10)
    {
        return $this->model->query()->paginate($pageSize);
    }

    public function get(int $id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->find($id)->delete();
    }
}
