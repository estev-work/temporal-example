<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Config\Values\Logger;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;

interface LoggerConfigInterface
{
    public function getChannelByKey(LoggerChannelEnum $channel): ?LoggerChannelInterface;

    /**
     * @return array<LoggerChannelInterface>
     */
    public function getChannels(): array;
}
