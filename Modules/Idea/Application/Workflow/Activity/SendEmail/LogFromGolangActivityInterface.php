<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity\SendEmail;

use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface LogFromGolangActivityInterface
{
    #[ActivityMethod(name: 'LogFromGolang')]
    public function logFromGolang(IdeaTemporalData $idea): string;
}
