<?php

namespace App\Providers;

use App\Repositories\MuseumRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\MuseumRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MuseumRepositoryInterface::class, MuseumRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
