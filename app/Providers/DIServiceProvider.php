<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Idea\Domain\Factory\IdeaFactory;
use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Service\WorkflowLauncherInterface;
use Modules\Idea\Infrastructure\Service\TemporalWorkflowLauncher;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\ValueObject\MoneyValueCalculatorInterface;
use Modules\Shared\Infrastructure\Service\MoneyPhpCalculatorInterface;
use Modules\Shared\Infrastructure\Service\UlidIdentifier;
use Modules\Shared\Infrastructure\Service\WorkflowLogger;
use Symfony\Component\Uid\Ulid;

class DIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WorkflowLoggerInterface::class, WorkflowLogger::class);
        $this->app->singleton(WorkflowLauncherInterface::class, TemporalWorkflowLauncher::class);
        $this->app->bind(MoneyValueCalculatorInterface::class, MoneyPhpCalculatorInterface::class);
        $this->app->bind(IdentifierInterface::class, function ($app) {
            return new UlidIdentifier((new Ulid())->toRfc4122());
        });
        $this->app->bind(IdeaFactoryInterface::class, function ($app) {
            return new IdeaFactory(app(IdentifierInterface::class), app(WorkflowLoggerInterface::class));
        });
    }

    public function boot(): void {}
}
