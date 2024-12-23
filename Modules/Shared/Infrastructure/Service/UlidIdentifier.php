<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Service;

use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\VO;
use Symfony\Component\Uid\Ulid;

final class UlidIdentifier extends VO implements IdentifierInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }


    public static function generate(): self
    {
        return new self((new Ulid())->toRfc4122());
    }

    public static function make(string $id): self
    {
        return new self($id);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function isValid(string $identifier): bool
    {
        return Ulid::isValid($identifier);
    }

    public static function getType(): string
    {
        return 'ULID';
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(IdentifierInterface $identifier): bool
    {
        return $this->value === $identifier->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
