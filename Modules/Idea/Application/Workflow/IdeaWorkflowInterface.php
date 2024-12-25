<?php

namespace Modules\Idea\Application\Workflow;

use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface IdeaWorkflowInterface
{
    #[WorkflowMethod(name: "IdeaWorkflow")]
    public function handle(string $ideaSerializable): \Generator;
}
