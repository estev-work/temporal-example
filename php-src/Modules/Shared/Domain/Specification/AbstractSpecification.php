<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Specification;

/**
 * @template T
 * @implements SpecificationInterface<T>
 */
abstract class AbstractSpecification implements SpecificationInterface
{

    public function and(SpecificationInterface $specification): SpecificationInterface
    {
        return new AndSpecification($this, $specification);
    }

    public function or(SpecificationInterface $specification): SpecificationInterface
    {
        return new OrSpecification($this, $specification);
    }

    public function not(): SpecificationInterface
    {
        return new NotSpecification($this);
    }
}
