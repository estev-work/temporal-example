<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

interface AggregateInterface {
    public function toArray(): array;
}
