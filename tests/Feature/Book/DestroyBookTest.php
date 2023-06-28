<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class DestroyBookTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_destroy_endpoint()
    {
        Auth::logout();

        $book = Book::factory()->create();

        $this->delete(route('v1.books.destroy', $book->id))
            ->assertUnauthorized();
    }

    /** @test */
    public function books_can_be_deleted()
    {
        $book = Book::factory()->create();

        $this->delete(route('v1.books.destroy', $book->id))
            ->assertSuccessful();

        $this->assertSoftDeleted('books', ['id' => $book->id]);
    }

    /** @test */
    public function non_existing_books_can_not_be_deleted()
    {
        $this->delete(route('v1.books.destroy', '123'))
            ->assertNotFound();
    }
}
