<?php

declare(strict_types=1);

namespace Modules\Idea\Infrastructure\Service;

use Keepsuit\LaravelTemporal\Facade\Temporal;
use Modules\Idea\Application\Workflow\TestWorkflow;
use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\Service\WorkflowLauncherInterface;
use Modules\Shared\Application\WorkflowLoggerInterface;

final readonly class TemporalWorkflowLauncher implements WorkflowLauncherInterface
{
    public function __construct(private WorkflowLoggerInterface $logger) {}

    public function startPayForIdeaWorkflow(Idea $idea): void
    {
        try {
            /** @var TestWorkflow $workflow */
            $workflow = Temporal::newWorkflow()
                ->withWorkflowId("idea_{$idea->getId()->getValue()}")
                ->build(TestWorkflow::class);
            Temporal::workflowClient()->start($workflow, $idea->serialize());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
