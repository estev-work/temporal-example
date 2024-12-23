<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow;

use Modules\Idea\Application\Workflow\Activity\CheckPaymentActivity;
use Modules\Idea\Application\Workflow\Activity\RejectedAfterTimeActivity;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityOptions;
use Temporal\Common\RetryOptions;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowInterface;

#[WorkflowInterface]
readonly class TestWorkflow
{
    private const int WAIT_TIME = 1;

    #[Workflow\WorkflowMethod(name: "TestWorkflow")]
    public function handle(string $ideaSerializable): \Generator
    {
        $logger = app(WorkflowLoggerInterface::class);
        $testOneActivity = Workflow::newActivityStub(
            CheckPaymentActivity::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        $res1 = yield $testOneActivity->run($ideaSerializable);

        yield Workflow::timer(\DateInterval::createFromDateString(self::WAIT_TIME . ' minutes'));

        $testTwoActivity = Workflow::newActivityStub(
            RejectedAfterTimeActivity::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        $res2 = yield $testTwoActivity->run($ideaSerializable, self::WAIT_TIME);

        $logger->debug('TEST', [$res1, $res2]);
    }
}
