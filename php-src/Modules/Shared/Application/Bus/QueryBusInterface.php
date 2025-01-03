<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Bus;

use Modules\Shared\Application\Query\QueryInterface;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
