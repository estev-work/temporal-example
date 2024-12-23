<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Commands\CreateIdea;

use Modules\Shared\Application\Command\CommandInterface;

final readonly class CreateIdeaCommand implements CommandInterface
{
    public function __construct(
        private string $title,
        private string $description,
        private float $price,
        private string $currency,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
