<?php

namespace Modules\Idea\Application\Workflow\Activity\RejectedAfterTime;

use Modules\Idea\Application\Workflow\Data\IdeaData;
use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface RejectedAfterTimeActivityInterface
{
    #[ActivityMethod(name: 'RejectedAfterTime')]
    public function rejectedAfterTime(IdeaData $ideaData, int $minutes): string;
}
