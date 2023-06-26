<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBookRequest;
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
     * @param StoreUpdateBookRequest $request
     * @return JsonResponse
     */
    public function store(StoreUpdateBookRequest $request)
    {
        $this->service->store($request->validated());

        return response()->json('', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
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
