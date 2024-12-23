<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Queries\GetIdeaById;

use Modules\Shared\Application\Query\QueryInterface;

final class GetIdeaByIdQuery implements QueryInterface
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
