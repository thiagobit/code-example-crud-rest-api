<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('v1.books.')->controller(\App\Http\Controllers\Api\v1\BookController::class)->group(function () {
    Route::get('/books', 'index')->name('index');
    Route::post('/books', 'store')->name('store');
    Route::get('/books/{id}', 'show')->name('show');
    Route::put('/books/{id}', 'update')->name('update');
    Route::delete('/books/{id}', 'destroy')->name('destroy');
});
