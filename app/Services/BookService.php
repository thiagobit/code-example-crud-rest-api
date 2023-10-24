<?php

namespace App\Services;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class BookService implements ServiceInterface
{
    public function __construct(private readonly BookRepositoryInterface $repo)
    {}

    public function store(array $data)
    {
        Cache::flush();

        return $this->repo->store($data);
    }

    public function all(array $request)
    {
        $page = $request['page'] ?? 1;
        $pageSize = $request['page_size'] ?? config('api.page_size');

        $books = Cache::tags([Book::getCacheKey($page, $pageSize)])->remember(Book::INDEX_CACHE_KEY, now()->addMinutes(30), function () use ($page, $pageSize) {
            return $this->repo->all($page, $pageSize);
        });

        return BookResource::collection($books);
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
