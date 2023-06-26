<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;

class BookService
{
    public function __construct(private readonly BookRepositoryInterface $repo)
    {}

    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function get(int $id)
    {
        return $this->repo->get($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->repo->destroy($id);
    }
}
