<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Application\Config\ConfigRepositoryInterface;
use Modules\Shared\Infrastructure\Config\LaravelConfigRepository;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ConfigRepositoryInterface::class, LaravelConfigRepository::class);
    }

    public function boot(): void {}
}
