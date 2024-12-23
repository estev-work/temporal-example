<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject;

use Modules\Shared\Domain\VO;

#[Deprecated]
final class MoneyValue extends VO
{
    private int $amount;
    public CurrencyEnum $currency;

    public function __construct(float $amount, CurrencyEnum $currency)
    {
        $this->currency = $currency;
        $this->amount = $this->convertFloatToInt($amount, $currency->getDecimalPrecision());
    }

    public function getAmount(): float
    {
        return $this->convertIntToFloat($this->amount, $this->currency->getDecimalPrecision());
    }

    public function getRawAmount(): int
    {
        return $this->amount;
    }

    public function equals(self $other, MoneyValueCalculatorInterface $calculator): bool
    {
        return $calculator->equals($this, $other);
    }

    public function greaterThan(self $other, MoneyValueCalculatorInterface $calculator): bool
    {
        return $calculator->greaterThan($this, $other);
    }

    public function lessThan(self $other, MoneyValueCalculatorInterface $calculator): bool
    {
        return $calculator->lessThan($this, $other);
    }

    public function add(self $other, MoneyValueCalculatorInterface $calculator): self
    {
        return $calculator->add($this, $other);
    }

    public function subtract(self $other, MoneyValueCalculatorInterface $calculator): self
    {
        return $calculator->subtract($this, $other);
    }

    private function convertFloatToInt(float $amount, int $precision): int
    {
        return (int)round($amount * (10 ** $precision));
    }

    private function convertIntToFloat(int $amount, int $precision): float
    {
        return $amount / (10 ** $precision);
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function getValue(): float
    {
        return $this->getAmount();
    }
}
