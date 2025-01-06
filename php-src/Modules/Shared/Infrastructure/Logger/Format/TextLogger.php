<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Format;

use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Infrastructure\Logger\BaseLogger;
use Modules\Shared\Infrastructure\Logger\LoggerWriterInterface;

final class TextLogger extends BaseLogger implements AppLoggerInterface
{
    public string $channel {
        get {
            return $this->channel ?? 'default';
        }
        set {
            $this->channel = $value;
        }
    }

    public function __construct(private readonly LoggerWriterInterface $writer) {}

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $log = strtoupper($level) . ": $message | Context: " . json_encode($context) . "\n";
        $this->writer->write($level, $this->channel, $log);
    }
}
