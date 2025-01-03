<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Idea\Application\Commands\CreateIdea\CreateIdeaCommand;
use Modules\Idea\Application\Commands\CreateIdea\CreateIdeaCommandHandler;
use Modules\Idea\Application\Queries\GetIdeaById\GetIdeaByIdHandler;
use Modules\Idea\Application\Queries\GetIdeaById\GetIdeaByIdQuery;
use Modules\Shared\Application\Bus\CommandBusInterface;
use Modules\Shared\Application\Bus\QueryBusInterface;
use Modules\Shared\Infrastructure\Bus\InMemoryCommandBus;
use Modules\Shared\Infrastructure\Bus\InMemoryQueryBus;

class BusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, function ($app) {
            $bus = new InMemoryCommandBus();
            $bus->registerHandler(
                CreateIdeaCommand::class,
                $app->make(CreateIdeaCommandHandler::class),
            );
            return $bus;
        });

        $this->app->singleton(QueryBusInterface::class, function ($app) {
            $bus = new InMemoryQueryBus();
            $bus->registerHandler(
                GetIdeaByIdQuery::class,
                $app->make(GetIdeaByIdHandler::class),
            );
            return $bus;
        });
    }

    public function boot(): void {}
}
