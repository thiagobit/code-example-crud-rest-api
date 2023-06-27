<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class ListBooksTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_cannot_access_list_endpoint()
    {
        Auth::logout();

        $this->get(route('v1.books.index'))
            ->assertUnauthorized();
    }

    /** @test */
    public function books_can_be_listed()
    {
        $book = Book::factory()->create();

        $this->get(route('v1.books.index'))
            ->assertSuccessful()
            ->assertSee($book->id)
            ->assertSee($book->name)
            ->assertSee($book->isbn)
            ->assertSee($book->value)
            ->assertDontSee($book->getCreatedAtColumn())
            ->assertDontSee($book->getUpdatedAtColumn())
            ->assertDontSee($book->deleted_at);
    }

    /** @test */
    public function deleted_books_can_not_be_listed()
    {
        $books = Book::factory()->count(5)->create();

        $books[0]->delete();

        $this->get(route('v1.books.index'))
            ->assertSuccessful()
            ->assertDontSee($books[0]);
    }

    /** @test */
    public function books_index_has_default_pagination_with_20_elements()
    {
        Book::factory()->count(100)->create();

        $this->get(route('v1.books.index'))
            ->assertSuccessful()
            ->assertJsonCount(20);
    }

    /** @test */
    public function books_index_has_page_as_parameter()
    {
        $books = Book::factory()->count(100)->create();

        $this->get(route('v1.books.index', ['page' => 1]))
            ->assertSuccessful()
            ->assertJsonCount(20)
            ->assertSee($books[19]->isbn)
            ->assertDontSee($books[20]->isbn);

        $this->get(route('v1.books.index', ['page' => 2]))
            ->assertSuccessful()
            ->assertJsonCount(20)
            ->assertSee($books[20]->isbn)
            ->assertDontSee($books[19]->isbn);
    }

    /** @test */
    public function books_index_has_page_size_as_parameter()
    {
        $books = Book::factory()->count(100)->create();

        $this->get(route('v1.books.index', ['page_size' => 2]))
            ->assertSuccessful()
            ->assertJsonCount(2)
            ->assertSee($books[0]->isbn)
            ->assertSee($books[1]->isbn)
            ->assertDontSee($books[2]->isbn);
    }

    /** @test */
    public function page_size_can_not_be_invalid()
    {
        $this->get(route('v1.books.index', ['page_size' => 0]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'page_size' => 'The page size field must be at least 1.'
            ]);

        $this->get(route('v1.books.index', ['page_size' => 'a']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'page_size' => 'The page size field must be an integer.'
            ]);
    }
}
