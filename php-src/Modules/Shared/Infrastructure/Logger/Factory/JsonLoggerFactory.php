<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Factory;

use Modules\Shared\Application\Config\ConfigRepositoryInterface;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Infrastructure\Logger\Format\JsonLogger;
use Modules\Shared\Infrastructure\Logger\Writer\FileWriter;

final class JsonLoggerFactory extends LoggerFactory
{
    public function __construct(private readonly ConfigRepositoryInterface $configRepository) {}

    public function createLogger(): AppLoggerInterface
    {
        return new JsonLogger(new FileWriter($this->configRepository));
    }
}
