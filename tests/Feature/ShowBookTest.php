<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Book $book;

    public function setUp(): void
    {
        parent::setUp();

        $this->book = Book::factory()->create();
    }

    /** @test */
    public function book_can_be_shown()
    {
        $this->get(route('v1.books.show', $this->book->id))
            ->assertSuccessful()
            ->assertSee($this->book->id)
            ->assertSee($this->book->name)
            ->assertSee($this->book->isbn)
            ->assertSee($this->book->value)
            ->assertDontSee($this->book->getCreatedAtColumn())
            ->assertDontSee($this->book->getUpdatedAtColumn())
            ->assertDontSee($this->book->deleted_at);
    }

    /** @test */
    public function deleted_books_can_not_be_shown()
    {
        $book = Book::factory()->trashed()->create();

        $this->get(route('v1.books.show', $book->id))
            ->assertNotFound();
    }

    /** @test */
    public function book_can_not_be_shown_with_invalid_id()
    {
        $this->get(route('v1.books.show', 'a'))
            ->assertServerError();
    }
}
