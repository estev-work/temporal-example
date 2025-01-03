<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\ValueObject;

use Modules\Shared\Domain\VO;

final class IdeaDescription extends VO
{
    private const int MAX_LENGTH = 1000;
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValid($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function assertValid(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Description cannot be empty.');
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException('Description cannot exceed 1000 characters.');
        }
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
