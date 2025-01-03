<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObject\Identifier;

interface IdentifierInterface
{
    /**
     * Создаёт новый ULID.
     *
     * @return self
     */
    public static function generate(): self;

    /**
     * Создаёт объект ULID на основе строки.
     *
     * @param string $id
     * @return self
     */
    public static function make(string $id): self;

    /**
     * Возвращает строковое представление идентификатора.
     *
     * @return string
     */
    public function __toString(): string;


    /**
     * Сравнивает текущий идентификатор с другим.
     *
     * @param self $identifier
     * @return bool
     */
    public function equals(self $identifier): bool;

    /**
     * Проверяет, является ли идентификатор валидным.
     *
     * @param string $identifier
     * @return bool
     */
    public static function isValid(string $identifier): bool;

    /**
     * Возвращает тип идентификатора (например, ULID, UUID).
     *
     * @return string
     */
    public static function getType(): string;

    public function getValue(): string;
}
