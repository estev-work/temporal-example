<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Factory;

use Modules\Shared\Application\Logger\AppLoggerInterface;

abstract class LoggerFactory
{
    abstract public function createLogger(): AppLoggerInterface;
}
