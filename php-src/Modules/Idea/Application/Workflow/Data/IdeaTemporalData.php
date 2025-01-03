<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Data;

use Modules\Idea\Domain\Idea;
use Modules\Shared\Application\Workflow\Data\DataObject;

final class IdeaTemporalData extends DataObject
{
    public string $id;

    public string $title;

    public string $description;

    public string $status;

    public int $price;
    public string $currency;

    public string $createdAt;
    public ?string $updatedAt;

    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param string $status
     * @param int $price
     * @param string $currency
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        string $id,
        string $title,
        string $description,
        string $status,
        int $price,
        string $currency,
        string $createdAt,
        ?string $updatedAt,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->price = $price;
        $this->currency = $currency;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }


    public static function fromEntity(Idea $idea): IdeaTemporalData
    {
        return new IdeaTemporalData(
            id: $idea->getId()->getValue(),
            title: $idea->getTitle()->getValue(),
            description: $idea->getDescription()->getValue(),
            status: $idea->getStatus()->getValue()->value,
            price: $idea->getPrice()->getRawAmount(),
            currency: $idea->getPrice()->getCurrency()->value,
            createdAt: $idea->getCreatedAt(),
            updatedAt: $idea->getUpdatedAt(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'price' => $this->price,
            'currency' => $this->currency,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
