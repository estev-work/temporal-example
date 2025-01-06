<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger\Writer;

use Modules\Shared\Application\Config\ConfigRepositoryInterface;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;
use Modules\Shared\Infrastructure\Logger\LoggerWriterInterface;

final readonly class FileWriter implements LoggerWriterInterface
{
    public function __construct(private ConfigRepositoryInterface $configRepository) {}

    public function write(string $level, LoggerChannelEnum $channel, string $log): void
    {
        $channel = $this->configRepository->getLoggerConfig()?->getChannelByKey($channel);
        if ($channel === null) {
            throw new \RuntimeException("Channel '{$channel}' not found");
        }

        if (!$channel->isEnabled()) {
            return;
        }

        if (!$channel->hasLevel($level)) {
            return;
        }

        $fileName = $channel->getFileName();

        try {
            file_put_contents(storage_path('/logs/' . $fileName), $log, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Failed to write to log file '{$fileName}': " . $e->getMessage(), 0, $e);
        }
    }
}
