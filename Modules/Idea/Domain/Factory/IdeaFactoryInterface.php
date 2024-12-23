<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Factory;

use Modules\Idea\Domain\Idea;

interface IdeaFactoryInterface
{
    public function create(
        string $title,
        string $description,
        float $price,
        string $currency,
    ): Idea;

    public function fromArray(array $data): Idea;

    public function unserialize(string $stringData): Idea;
}
