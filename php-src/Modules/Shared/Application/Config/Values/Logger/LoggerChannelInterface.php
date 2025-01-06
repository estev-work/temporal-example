<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Config\Values\Logger;

use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerFormatEnum;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerPeriodEnum;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerTypeEnum;

interface LoggerChannelInterface
{
    public function getFileName(): string;

    public function getFormat(): LoggerFormatEnum;

    public function getType(): LoggerTypeEnum;

    public function hasLevel(string $level): bool;

    public function isEnabled(): bool;

    public function getPeriod(): ?LoggerPeriodEnum;

    public function getDays(): ?int;
}
