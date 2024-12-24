<?php

namespace Modules\Idea\Application\Workflow\Activity\RejectedAfterTime;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface RejectedAfterTimeActivityInterface
{
    #[ActivityMethod(name: 'Отмена идеи через время')]
    public function run(string $ideaSerializable, int $minutes): string;
}
