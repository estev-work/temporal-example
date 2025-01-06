<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Format;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Infrastructure\Logger\BaseLogger;
use Modules\Shared\Infrastructure\Logger\LoggerWriterInterface;

final class JsonLogger extends BaseLogger implements AppLoggerInterface
{
    public LoggerChannelEnum $channel {
        get {
            return $this->channel ?? LoggerChannelEnum::DEFAULT;
        }
        set {
            $this->channel = $value;
        }
    }

    public function __construct(
        private readonly LoggerWriterInterface $writer,
    ) {}

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $log = json_encode(
            [
                'level' => $level,
                'message' => $message,
                'context' => $context,
                'timestamp' => date('Y-m-d H:i:s'),
            ],
        );
        $this->writer->write(
            $level,
            $this->channel,
            $log,
        );
    }
}
