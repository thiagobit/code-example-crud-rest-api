<?php

namespace Tests\Unit;

use App\Models\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    /** @test */
    public function getCacheKey_returns_correct_cache_key()
    {
        $page = 1;
        $pageSize = 20;

        $cacheKey = Book::getCacheKey($page, $pageSize);
        $this->assertEquals(Book::INDEX_CACHE_KEY . "_" . $page . "_" . $pageSize, $cacheKey);
    }
}
