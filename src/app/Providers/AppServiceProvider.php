<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Package\SomeSpecificApplication\CreateApp\Adaptor\CreateAppControllerInterface;
use Package\SomeSpecificApplication\CreateApp\Concrete\Adaptor\CreateAppController;
use Package\SomeSpecificApplication\CreateApp\Concrete\Infrastructre\Repository\AuthLoggerRepository;
use Package\SomeSpecificApplication\CreateApp\Domain\Repository\SampleRepositoryInterface;

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
