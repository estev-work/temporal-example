<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Config\Values\Logger;


use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;
use Modules\Shared\Application\Config\Values\Logger\LoggerChannelInterface;
use Modules\Shared\Application\Config\Values\Logger\LoggerConfigInterface;

final readonly class LoggerConfig implements LoggerConfigInterface
{
    private array $channels;

    public function __construct(array $config)
    {
        $this->initLoggerConfig($config);
    }

    private function initLoggerConfig(array $config): void
    {
        /** @var array<LoggerChannel> $value */
        foreach ($config as $key => $value) {
            match ($key) {
                'channels' => $this->channels = $value,
            };
        }
    }

    public function getChannelByKey(LoggerChannelEnum $channel): ?LoggerChannelInterface
    {
        if (isset($this->channels[$channel->name])) {
            return $this->channels[$channel->name];
        }
        return null;
    }

    public function getChannels(): array
    {
        return $this->channels;
    }
}
