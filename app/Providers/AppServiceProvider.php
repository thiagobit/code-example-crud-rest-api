<?php

namespace App\Providers;

use App\Models\Book;
use App\Repositories\BookRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\BookRepositoryInterface', function () {
            return new BookRepositoryEloquent(new Book());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
