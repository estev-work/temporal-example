<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Application\Config\ConfigRepositoryInterface;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Infrastructure\Logger\Factory\JsonLoggerFactory;
use Modules\Shared\Infrastructure\Logger\Factory\LoggerFactory;

class LoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoggerFactory::class, function ($app) {
            return new JsonLoggerFactory($app->make(ConfigRepositoryInterface::class));
        });
        $this->app->bind(AppLoggerInterface::class, function ($app) {
            $factory = $app->make(LoggerFactory::class);
            return $factory->createLogger();
        });
    }

    public function boot(): void {}
}
