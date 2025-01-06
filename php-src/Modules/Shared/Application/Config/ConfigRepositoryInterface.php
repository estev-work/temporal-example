<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Config;

use Modules\Shared\Application\Config\Values\Logger\LoggerConfigInterface;

interface ConfigRepositoryInterface
{
    public function getLoggerConfig(): LoggerConfigInterface;
}
