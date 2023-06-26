<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\IndexBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(private readonly BookService $service)
    {}

    /**
     * Display a listing of books.
     *
     * @param IndexBookRequest $request
     * @return JsonResponse
     */
    public function index(IndexBookRequest $request): JsonResponse
    {
        $books = $this->service->all($request->validated());

        return response()->json($books, 200);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param StoreBookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return response()->json('', 201);
    }

    /**
     * Display the specified book.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = $this->service->get($id);

        if (!$book) {
            abort(404, 'Book not found.');
        }

        return response()->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
