<?php

namespace App\Providers;

use Package\SomeSpecificApplication\CreateApp\Controller\CreateAppControllerInterface;
use Package\SomeSpecificApplication\CreateApp\Domain\Repository\SampleRepositoryInterface;
use Package\SomeSpecificApplication\CreateApp\Infrastructure\Controller\CreateAppController;
use Package\SomeSpecificApplication\CreateApp\Infrastructure\Repository\AuthLoggerRepository;
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

        $this->app->bind(
            CreateAppControllerInterface::class,
            CreateAppController::class
        );
    }
}
