<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Config\Values\Logger;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerFormatEnum;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerPeriodEnum;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerTypeEnum;
use Modules\Shared\Application\Config\Values\Logger\LoggerChannelInterface;
use Psr\Log\LogLevel;

final readonly class LoggerChannel implements LoggerChannelInterface
{
    /**
     * @param string $fileName
     * @param LoggerFormatEnum $format
     * @param LoggerTypeEnum $type
     * @param array<LogLevel> $levels
     * @param bool $enabled
     * @param LoggerPeriodEnum|null $period
     * @param int|null $days
     */
    public function __construct(
        private string $fileName,
        private LoggerFormatEnum $format,
        private LoggerTypeEnum $type,
        private array $levels,
        private bool $enabled,
        private ?LoggerPeriodEnum $period,
        private ?int $days,
    ) {}

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFormat(): LoggerFormatEnum
    {
        return $this->format;
    }

    public function getType(): LoggerTypeEnum
    {
        return $this->type;
    }

    public function hasLevel(string $level): bool
    {
        return in_array($level, $this->levels);
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getPeriod(): ?LoggerPeriodEnum
    {
        return $this->period;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }
}
