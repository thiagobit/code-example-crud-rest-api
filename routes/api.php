<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BookController;
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

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::name('books.')->controller(BookController::class)->group(function () {
            Route::get('/books', 'index')->name('index');
            Route::post('/books', 'store')->name('store');
            Route::get('/books/{id}', 'show')->name('show');
            Route::put('/books/{id}', 'update')->name('update');
            Route::delete('/books/{id}', 'destroy')->name('destroy');
        });
    });
});
