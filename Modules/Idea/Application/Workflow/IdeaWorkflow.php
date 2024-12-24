<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow;

use Modules\Idea\Application\Workflow\Activity\CheckPayment\CheckPaymentActivityInterface;
use Modules\Idea\Application\Workflow\Activity\RejectedAfterTime\RejectedAfterTimeActivityInterface;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityOptions;
use Temporal\Common\RetryOptions;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowInterface;

#[WorkflowInterface]
readonly class IdeaWorkflow
{
    private const int WAIT_TIME = 1;

    #[Workflow\WorkflowMethod(name: "IdeaWorkflow")]
    public function handle(string $ideaSerializable): \Generator
    {
        $logger = app(WorkflowLoggerInterface::class);
        $checkPaymentActivity = Workflow::newActivityStub(
            CheckPaymentActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        $checkPaymentActivityResult = yield $checkPaymentActivity->run($ideaSerializable);

        yield Workflow::timer(\DateInterval::createFromDateString(self::WAIT_TIME . ' day'));

        $rejectedAfterTimeActivity = Workflow::newActivityStub(
            RejectedAfterTimeActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        $rejectedAfterTimeActivityResult = yield $rejectedAfterTimeActivity->run(
            $ideaSerializable,
            self::WAIT_TIME,
        );

        $logger->debug('Workflow completed: ', [$checkPaymentActivityResult, $rejectedAfterTimeActivityResult]);
    }
}
