<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Bus;

use Modules\Shared\Application\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
