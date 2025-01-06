<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Config;

use Modules\Shared\Application\Config\ConfigRepositoryInterface;
use Modules\Shared\Application\Config\Values\Logger\LoggerConfigInterface;
use Modules\Shared\Infrastructure\Config\Values\Logger\LoggerConfig;

final class LaravelConfigRepository implements ConfigRepositoryInterface
{
    public function getLoggerConfig(): LoggerConfigInterface
    {
        $config = include __DIR__ . '/../../../../config/project/logger/logging.php';
        return new LoggerConfig($config);
    }
}
