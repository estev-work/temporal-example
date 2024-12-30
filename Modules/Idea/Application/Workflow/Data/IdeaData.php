<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Data;

use Illuminate\Support\Facades\Log;
use Modules\Idea\Domain\Idea;
use Spatie\LaravelData\Data;

final class IdeaData extends Data
{
    public readonly string $id;

    public readonly string $title;

    public readonly string $description;

    public readonly string $status;

    public readonly int $price;
    public readonly string $currency;

    public readonly string $createdAt;
    public readonly ?string $updatedAt;

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


    public static function fromEntity(Idea $idea): IdeaData
    {
        $ideaData = new IdeaData(
            id: $idea->getId()->getValue(),
            title: $idea->getTitle()->getValue(),
            description: $idea->getDescription()->getValue(),
            status: $idea->getStatus()->getValue()->value,
            price: $idea->getPrice()->getRawAmount(),
            currency: $idea->getPrice()->getCurrency()->value,
            createdAt: $idea->getCreatedAt(),
            updatedAt: $idea->getUpdatedAt(),
        );
        Log::channel('workflow')->debug("DATA", $ideaData->toArray());
        return $ideaData;
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

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
