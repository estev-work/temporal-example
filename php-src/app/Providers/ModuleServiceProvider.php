<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Idea\Domain\Factory\IdeaFactory;
use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\ValueObject\MoneyValueCalculatorInterface;
use Modules\Shared\Infrastructure\Service\MoneyPhpCalculator;
use Modules\Shared\Infrastructure\Service\UlidIdentifier;
use Symfony\Component\Uid\Ulid;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MoneyValueCalculatorInterface::class, MoneyPhpCalculator::class);
        $this->app->bind(IdentifierInterface::class, function ($app) {
            return new UlidIdentifier(new Ulid()->toRfc4122());
        });
        $this->app->bind(IdeaFactoryInterface::class, function ($app) {
            return new IdeaFactory(app(IdentifierInterface::class), app(AppLoggerInterface::class));
        });
    }

    public function boot(): void {}
}
