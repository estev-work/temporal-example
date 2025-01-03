<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Command;

interface CommandHandlerInterface
{
    public function __invoke(CommandInterface $command): string|bool;
}
