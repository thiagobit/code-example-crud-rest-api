<?php

namespace App\Services;

use App\Http\Requests\IndexBookRequest;
use App\Http\Resources\BookResource;
use App\Repositories\BookRepositoryInterface;

class BookService
{
    public function __construct(private readonly BookRepositoryInterface $repo)
    {}

    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    public function all(IndexBookRequest $request)
    {
        $pageSize = $request->page_size ?? config('api.page_size');

        return BookResource::collection($this->repo->all($pageSize));
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
