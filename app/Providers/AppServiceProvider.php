<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\MovieService;
use App\Services\PosterService;
use App\Services\GenreService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('UserFacade', UserService::class);
        $this->app->bind('MovieFacade', MovieService::class);
        $this->app->bind('PosterFacade', PosterService::class);
        $this->app->bind('GenreFacade', GenreService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
