<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\ValueObject;

use Modules\Idea\Domain\ValueObject\Enums\IdeaStatusEnum;
use Modules\Shared\Domain\VO;

final class IdeaStatus extends VO
{

    private IdeaStatusEnum $value;

    private function __construct(IdeaStatusEnum $status)
    {
        $this->value = $status;
    }

    public static function new(): self
    {
        return new self(IdeaStatusEnum::NEW);
    }

    public static function approved(): self
    {
        return new self(IdeaStatusEnum::APPROVED);
    }

    public static function rejected(): self
    {
        return new self(IdeaStatusEnum::REJECTED);
    }

    public static function closed(): self
    {
        return new self(IdeaStatusEnum::CLOSED);
    }

    public function canRejected(): bool
    {
        return $this->value !== IdeaStatusEnum::APPROVED;
    }

    public function canClosed(): bool
    {
        return !in_array($this->value, [
            IdeaStatusEnum::APPROVED,
            IdeaStatusEnum::REJECTED,
        ], true);
    }

    public function __toString(): string
    {
        return $this->value->name;
    }

    public function getValue(): IdeaStatusEnum
    {
        return $this->value;
    }
}
