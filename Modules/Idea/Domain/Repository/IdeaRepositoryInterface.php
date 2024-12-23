<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Repository;

use Modules\Idea\Domain\Idea;

interface IdeaRepositoryInterface
{
    public function save(Idea $idea): void;

    public function findById(string $id): ?Idea;

    public function findAll(): array;
}
