<?php

namespace Modules\Idea\Application\Workflow;

use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface IdeaWorkflowInterface
{
    #[WorkflowMethod(name: "IdeaWorkflow")]
    public function handle(IdeaTemporalData $ideaData): \Generator;
}
