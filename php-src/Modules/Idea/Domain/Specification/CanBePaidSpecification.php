<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Specification;

use Modules\Idea\Domain\Idea;
use Modules\Shared\Domain\Specification\AbstractSpecification;

/**
 * @extends AbstractSpecification<Idea>
 */
class CanBePaidSpecification extends AbstractSpecification
{
    /**
     * @param Idea $candidate
     * @return bool
     */
    public function isSatisfiedBy(mixed $candidate): bool
    {
        //TODO
        if (!$candidate instanceof Idea) {
            throw new \InvalidArgumentException('Expected an instance of Idea.');
        }
        return $candidate->getStatus()->canClosed();
    }
}
