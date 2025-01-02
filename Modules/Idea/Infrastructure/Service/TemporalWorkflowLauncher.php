<?php

declare(strict_types=1);

namespace Modules\Idea\Infrastructure\Service;

use Keepsuit\LaravelTemporal\Facade\Temporal;
use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Modules\Idea\Application\Workflow\IdeaWorkflow;
use Modules\Idea\Application\Workflow\IdeaWorkflowInterface;
use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\Service\WorkflowLauncherInterface;
use Modules\Shared\Application\WorkflowLoggerInterface;

final readonly class TemporalWorkflowLauncher implements WorkflowLauncherInterface
{
    public function __construct(private WorkflowLoggerInterface $logger) {}

    public function startPayForIdeaWorkflow(Idea $idea): void
    {
        try {
            /** @var IdeaWorkflow $workflow */
            $workflow = Temporal::newWorkflow()
                ->withWorkflowId("idea_{$idea->getId()->getValue()}")
                ->build(IdeaWorkflowInterface::class);

            Temporal::workflowClient()->start($workflow, IdeaTemporalData::fromEntity($idea));
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
