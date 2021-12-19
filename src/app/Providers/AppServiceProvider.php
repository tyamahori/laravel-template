<?php

namespace App\Providers;

use Domain\SomeSpecificApplication\CreateApp\Domain\Repository\SampleRepositoryInterface;
use Domain\SomeSpecificApplication\CreateApp\Infrastructure\Repository\AuthLoggerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(
            SampleRepositoryInterface::class,
            AuthLoggerRepository::class
        );
    }
}
