<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyBookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function books_can_be_deleted()
    {
        $book = Book::factory()->create();

        $this->delete(route('v1.books.destroy', $book->id))
            ->assertSuccessful();

        $this->assertSoftDeleted('books', $book->toArray());
    }

    /** @test */
    public function non_existing_books_can_not_be_deleted()
    {
        $this->delete(route('v1.books.destroy', '123'))
            ->assertNotFound();
    }
}
