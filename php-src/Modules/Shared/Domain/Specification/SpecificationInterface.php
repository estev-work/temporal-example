<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Specification;

/**
 * @template T
 */
interface SpecificationInterface
{
    /**
     * Проверяет, удовлетворяет ли объект условиям спецификации.
     *
     * @param T $candidate Объект для проверки.
     * @return bool Результат проверки.
     */
    public function isSatisfiedBy(mixed $candidate): bool;

    /**
     * Логическое "И" для объединения двух спецификаций.
     *
     * @param SpecificationInterface<T> $specification
     * @return SpecificationInterface<T>
     */
    public function and(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Логическое "ИЛИ" для объединения двух спецификаций.
     *
     * @param SpecificationInterface<T> $specification
     * @return SpecificationInterface<T>
     */
    public function or(SpecificationInterface $specification): SpecificationInterface;

    /**
     * Логическое "НЕ" для инверсии спецификации.
     *
     * @return SpecificationInterface<T>
     */
    public function not(): SpecificationInterface;
}
