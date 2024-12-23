<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Query;

interface QueryHandlerInterface
{

    public function __invoke(QueryInterface $command): void;
}
