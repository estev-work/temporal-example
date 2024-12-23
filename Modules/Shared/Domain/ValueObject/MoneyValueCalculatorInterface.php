<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject;

interface MoneyValueCalculatorInterface
{
    public function equals(MoneyValue $a, MoneyValue $b): bool;

    public function greaterThan(MoneyValue $a, MoneyValue $b): bool;

    public function lessThan(MoneyValue $a, MoneyValue $b): bool;

    public function add(MoneyValue $a, MoneyValue $b): MoneyValue;

    public function subtract(MoneyValue $a, MoneyValue $b): MoneyValue;
}
