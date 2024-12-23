<?php

declare(strict_types=1);

namespace Modules\Idea\Domain;

use Modules\Idea\Domain\ValueObject\IdeaDescription;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Domain\Aggregate;
use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\ValueObject\MoneyValue;

final class Idea extends Aggregate
{
    private IdentifierInterface $id;

    private IdeaTitle $title;

    private IdeaDescription $description;

    private IdeaStatus $status;

    private MoneyValue $price;

    public function __construct(
        IdentifierInterface $id,
        IdeaTitle $title,
        IdeaDescription $description,
        IdeaStatus $status,
        MoneyValue $price,
        ?string $createdAt = null,
        ?string $updatedAt = null,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->price = $price;

        if ($createdAt !== null) {
            $this->createdAt = $createdAt;
        }
        if ($updatedAt !== null) {
            $this->updatedAt = $updatedAt;
        }
    }

    public function changeStatus(IdeaStatus $status): self
    {
        $this->status = $status;
        $this->updated();
        return $this;
    }

    public function changeTitle(IdeaTitle $newTitle): self
    {
        $this->title = $newTitle;
        $this->updated();
        return $this;
    }

    public function changeDescription(IdeaDescription $newDescription): self
    {
        $this->description = $newDescription;
        $this->updated();
        return $this;
    }

    public function changePrice(MoneyValue $newPrice): self
    {
        $this->price = $newPrice;
        return $this;
    }

    public function getId(): IdentifierInterface
    {
        return $this->id;
    }

    public function getTitle(): IdeaTitle
    {
        return $this->title;
    }

    public function getDescription(): IdeaDescription
    {
        return $this->description;
    }

    public function getStatus(): IdeaStatus
    {
        return $this->status;
    }

    public function getPrice(): MoneyValue
    {
        return $this->price;
    }
}
