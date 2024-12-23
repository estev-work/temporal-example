<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Specification;

/**
 * @template T
 * @extends AbstractSpecification<T>
 */
class NotSpecification extends AbstractSpecification
{
    /**
     * @param SpecificationInterface<T> $specification
     */
    public function __construct(private readonly SpecificationInterface $specification) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return !$this->specification->isSatisfiedBy($candidate);
    }
}
