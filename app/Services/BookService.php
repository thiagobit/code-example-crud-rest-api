<?php

namespace App\Services;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\BookRepositoryInterface;

class BookService
{
    public function __construct(private readonly BookRepositoryInterface $repo)
    {}

    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    public function all(array $request)
    {
        $pageSize = $request['page_size'] ?? config('api.page_size');

        return BookResource::collection($this->repo->all($pageSize));
    }

    public function get(int $id)
    {
        $book = $this->repo->get($id);

        if (!$book) {
            return null;
        }

        return new BookResource($book);
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
