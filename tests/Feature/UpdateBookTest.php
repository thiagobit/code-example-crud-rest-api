<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class UpdateBookTest extends ApiTestCase
{
    use RefreshDatabase;

    private Book $book;

    public function setUp(): void
    {
        parent::setUp();

        $this->book = Book::factory()->create();
    }

    /** @test */
    public function guests_cannot_access_update_endpoint()
    {
        Auth::logout();

        $book = Book::factory()->make()->toArray();

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnauthorized();
    }

    /** @test */
    public function books_can_be_updated()
    {
        $book = Book::factory()->make()->toArray();

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertSuccessful();

        $this->book->refresh();

        $this->assertEquals($this->book->name, $book['name']);
        $this->assertEquals($this->book->isbn, $book['isbn']);
        $this->assertEquals($this->book->value, $book['value']);
    }

    /** @test */
    public function deleted_books_can_not_be_updated()
    {
        $book = Book::factory()->make()->toArray();
        $this->book->delete();

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertNotFound();

        $this->book->refresh();

        $this->assertEquals($this->book->name, $this->book->name);
        $this->assertEquals($this->book->isbn, $this->book->isbn);
        $this->assertEquals($this->book->value, $this->book->value);
    }

    /** @test */
    public function books_can_not_be_updated_with_invalid_name()
    {
        $book = Book::factory()->make()->toArray();

        $book['name'] = ['a'];

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must be a string.',
            ]);

        $book['name'] = str_repeat('a', 256);

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'The name field must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function books_can_not_be_updated_with_invalid_isbn()
    {
        $otherBook = Book::factory()->create();
        $book = Book::factory()->make()->toArray();

        $book['isbn'] = $otherBook->isbn;

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn has already been taken.',
            ]);

        $book['isbn'] = 'a';

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn field must be an integer.',
            ]);

        $book['isbn'] = '123456789';

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'isbn' => 'The isbn field must have 10 or 13 digits.',
            ]);
    }

    /** @test */
    public function books_can_not_be_updated_with_invalid_value()
    {
        $book = Book::factory()->make()->toArray();

        $book['value'] = 999.999;

        $this->put(route('v1.books.update', array_merge(['id' => $this->book->id], $book)))
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'value' => [
                    'The value field must have 0-2 decimal places.',
                    'The value field must not be greater than 999.99.',
                ],
            ]);
    }
}
