<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Service;

use Modules\Idea\Domain\Idea;

interface WorkflowLauncherInterface
{
    public function startPayForIdeaWorkflow(Idea $idea): void;
}
