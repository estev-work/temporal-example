<?php

namespace Modules\Shared\Domain\ValueObject;

enum CurrencyEnum: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case RUB = 'RUB';

    public function getDecimalPrecision(): int
    {
        return match ($this) {
            self::USD, self::EUR, self::RUB => 2,
        };
    }
}
