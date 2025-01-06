<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;

interface LoggerWriterInterface
{
    public function write(string $level, LoggerChannelEnum $channel, string $log): void;
}
