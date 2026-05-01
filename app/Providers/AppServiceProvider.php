<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD

=======
use Illuminate\Pagination\Paginator;
>>>>>>> origin/dev2
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
<<<<<<< HEAD
    public function boot(): void
    {
        //
=======
  public function boot(): void
    {
        Paginator::useBootstrap();
>>>>>>> origin/dev2
    }
}
