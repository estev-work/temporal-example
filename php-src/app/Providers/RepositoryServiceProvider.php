<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Idea\Infrastructure\Persistence\PDOIdeaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IdeaRepositoryInterface::class, function ($app) {
            $pdo = DB::connection()->getPdo();
            return new PDOIdeaRepository($pdo);
        });
    }

    public function boot(): void {}
}
