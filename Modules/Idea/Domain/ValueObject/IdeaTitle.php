<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\ValueObject;

use Modules\Shared\Domain\VO;

final class IdeaTitle extends VO
{
    private const int MAX_LENGTH = 255;

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
            throw new \InvalidArgumentException('Title cannot be empty.');
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Title cannot exceed %d characters.', self::MAX_LENGTH),
            );
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
