<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Factory;

use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Infrastructure\Logger\Format\TextLogger;
use Modules\Shared\Infrastructure\Logger\Writer\FileWriter;

final class TextLoggerFactory extends LoggerFactory
{
    public function __construct(private readonly string $path) {}

    public function createLogger(): AppLoggerInterface
    {
        return new TextLogger(new FileWriter($this->path));
    }
}
