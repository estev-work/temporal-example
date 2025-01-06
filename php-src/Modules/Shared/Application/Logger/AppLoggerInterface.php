<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Logger;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;
use Psr\Log\LoggerInterface;

interface AppLoggerInterface extends LoggerInterface
{
    public LoggerChannelEnum $channel {
        get;
        set;
    }
}
