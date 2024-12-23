<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Bus;

use Modules\Shared\Application\Bus\QueryBusInterface;
use Modules\Shared\Application\Query\QueryHandlerInterface;
use Modules\Shared\Application\Query\QueryInterface;
use RuntimeException;

final class InMemoryQueryBus implements QueryBusInterface
{
    /**
     * @var array<class-string<QueryInterface>, QueryHandlerInterface>
     */
    private array $handlers = [];

    /**
     * Зарегистрировать хендлер для конкретного запроса.
     */
    public function registerHandler(string $queryClass, QueryHandlerInterface $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function ask(QueryInterface $query): mixed
    {
        $queryClass = $query::class;

        if (!isset($this->handlers[$queryClass])) {
            throw new RuntimeException("No handler found for query $queryClass");
        }

        $handler = $this->handlers[$queryClass];
        return $handler($query);
    }
}
