<?php

namespace Modules\Idea\Application\Workflow\Activity\RejectedAfterTime;

use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface RejectedAfterTimeActivityInterface
{
    #[ActivityMethod(name: 'RejectedAfterTime')]
    public function rejectedAfterTime(IdeaTemporalData $ideaData, int $minutes): string;
}
