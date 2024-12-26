<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Service;

use Modules\Shared\Domain\ValueObject\CurrencyEnum;
use Modules\Shared\Domain\ValueObject\MoneyValue;
use Modules\Shared\Domain\ValueObject\MoneyValueCalculatorInterface;
use Money\Currency;
use Money\Money;

final class MoneyPhpCalculator implements MoneyValueCalculatorInterface
{
    public function equals(MoneyValue $a, MoneyValue $b): bool
    {
        $moneyA = $this->toMoney($a);
        $moneyB = $this->toMoney($b);

        return $moneyA->equals($moneyB);
    }

    public function greaterThan(MoneyValue $a, MoneyValue $b): bool
    {
        $moneyA = $this->toMoney($a);
        $moneyB = $this->toMoney($b);

        return $moneyA->greaterThan($moneyB);
    }

    public function lessThan(MoneyValue $a, MoneyValue $b): bool
    {
        $moneyA = $this->toMoney($a);
        $moneyB = $this->toMoney($b);

        return $moneyA->lessThan($moneyB);
    }

    public function add(MoneyValue $a, MoneyValue $b): MoneyValue
    {
        $moneyA = $this->toMoney($a);
        $moneyB = $this->toMoney($b);

        $result = $moneyA->add($moneyB);

        return $this->fromMoney($result, $a->currency);
    }

    public function subtract(MoneyValue $a, MoneyValue $b): MoneyValue
    {
        $moneyA = $this->toMoney($a);
        $moneyB = $this->toMoney($b);

        $result = $moneyA->subtract($moneyB);

        return $this->fromMoney($result, $a->currency);
    }

    private function toMoney(MoneyValue $moneyValue): Money
    {
        return new Money((string)$moneyValue->getRawAmount(), new Currency($moneyValue->currency->value));
    }

    private function fromMoney(Money $money, CurrencyEnum $currency): MoneyValue
    {
        return new MoneyValue(
            (float)$money->getAmount() / (10 ** $currency->getDecimalPrecision()),
            $currency,
        );
    }
}
