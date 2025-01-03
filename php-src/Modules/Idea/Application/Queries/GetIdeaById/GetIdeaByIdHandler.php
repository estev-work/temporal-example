<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Queries\GetIdeaById;

use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Shared\Application\Query\QueryHandlerInterface;
use Modules\Shared\Application\Query\QueryInterface;

final readonly class GetIdeaByIdHandler implements QueryHandlerInterface
{
    public function __construct(private IdeaRepositoryInterface $repository) {}

    public function __invoke(QueryInterface|GetIdeaByIdQuery $query): ?Idea
    {
        return $this->repository->findById($query->getId());
    }
}
