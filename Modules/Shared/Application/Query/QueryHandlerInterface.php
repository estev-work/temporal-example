<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Query;

use Modules\Shared\Domain\AggregateInterface;

interface QueryHandlerInterface
{
    public function __invoke(QueryInterface $query): ?AggregateInterface;
}
