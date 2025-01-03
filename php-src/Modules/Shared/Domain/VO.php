<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

use JsonException;

abstract class VO implements \Serializable
{
    abstract public function getValue(): mixed;

    public function toArray(): array
    {
        return ['value' => $this->getValue()];
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }


    public function unserialize(string $data): void {}

    public function __serialize(): array
    {
        return $this->toArray();
    }

    public function __unserialize(array $data): void {}
}
