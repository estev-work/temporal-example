<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Workflow\Data;

use Spatie\LaravelData\Data;

class DataObject extends Data
{

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
