<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Bus;

use Modules\Shared\Application\Bus\CommandBusInterface;
use Modules\Shared\Application\Command\CommandHandlerInterface;
use Modules\Shared\Application\Command\CommandInterface;
use RuntimeException;

final class InMemoryCommandBus implements CommandBusInterface
{
    /**
     * @var array<class-string<CommandInterface>, CommandHandlerInterface>
     */
    private array $handlers = [];

    /**
     * Зарегистрировать хендлер для конкретной команды.
     */
    public function registerHandler(string $commandClass, CommandHandlerInterface $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function dispatch(CommandInterface $command): string|bool
    {
        $commandClass = $command::class;

        if (!isset($this->handlers[$commandClass])) {
            throw new RuntimeException("No handler found for command $commandClass");
        }

        $handler = $this->handlers[$commandClass];
        return $handler($command);
    }
}
