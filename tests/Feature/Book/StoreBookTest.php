<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class StoreBookTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_store_endpoint()
    {
        Auth::logout();

        $book = Book::factory()->make()->toArray();

        $this->post(route('v1.books.store', $book))
            ->assertUnauthorized();
    }

    /** @test */
    public function books_can_be_stored()
    {
        $book1 = Book::factory()->make()->toArray();
        $book2 = Book::factory()->isbn10()->make()->toArray();

        $this->post(route('v1.books.store', $book1))
            ->assertSuccessful();
        $this->assertDatabaseHas('books', $book1);

        $this->post(route('v1.books.store', $book2))
            ->assertSuccessful();
        $this->assertDatabaseHas('books', $book2);
    }

    /** @test */
    public function books_can_be_stored_with_null_isbn()
    {
        $book = Book::factory()->make()->toArray();

        unset($book['isbn']);

        $this->post(route('v1.books.store', $book))
            ->assertSuccessful();
        $this->assertDatabaseHas('books', $book);
    }

    /** @test */
    public function books_can_be_stored_with_null_value()
    {
        $book = Book::factory()->make()->toArray();

        unset($book['value']);

        $this->post(route('v1.books.store', $book))
            ->assertSuccessful();
        $this->assertDatabaseHas('books', $book);
    }

    /** @test */
    public function books_can_not_be_stored_with_invalid_name()
    {
        $book = Book::factory()->make()->toArray();

        $book['name'] = '';

        $this->post(route('v1.books.store', $book))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);

        $book['name'] = ['a'];

        $this->post(route('v1.books.store', $book))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must be a string.',
            ]);

        $book['name'] = str_repeat('a', 256);

        $this->post(route('v1.books.store', $book))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function books_can_not_be_stored_with_invalid_isbn()
    {
        $createdBook = Book::factory()->create();
        $newBook = Book::factory()->make()->toArray();

        $newBook['isbn'] = $createdBook->isbn;

        $this->post(route('v1.books.store', $newBook))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn has already been taken.',
            ]);

        $newBook['isbn'] = 'a';

        $this->post(route('v1.books.store', $newBook))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn field must be an integer.',
            ]);

        $newBook['isbn'] = '123456789';

        $this->post(route('v1.books.store', $newBook))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn field must have 10 or 13 digits.',
            ]);
    }

    /** @test */
    public function books_can_not_be_stored_with_invalid_value()
    {
        $book = Book::factory()->make()->toArray();

        $book['value'] = 999.999;

        $this->post(route('v1.books.store', $book))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'value' => [
                    'The value field must have 0-2 decimal places.',
                    'The value field must not be greater than 999.99.',
                ],
            ]);
    }
}
