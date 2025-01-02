<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity\CheckPayment;

use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface CheckPaymentActivityInterface
{
    #[ActivityMethod(name: 'CheckPayment')]
    public function checkPayment(IdeaTemporalData $ideaData): string;
}
