<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    const INDEX_CACHE_KEY = 'books_index';

    protected $fillable = [
        'name',
        'isbn',
        'value',
    ];
}
