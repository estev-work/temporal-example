<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow;

use Modules\Idea\Application\Workflow\Activity\CheckPayment\CheckPaymentActivityInterface;
use Modules\Idea\Application\Workflow\Activity\RejectedAfterTime\RejectedAfterTimeActivityInterface;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityOptions;
use Temporal\Common\RetryOptions;
use Temporal\Workflow;

readonly class IdeaWorkflow implements IdeaWorkflowInterface
{
    private const int WAIT_TIME = 1;

    #[Workflow\WorkflowMethod(name: "IdeaWorkflow")]
    public function handle(string $ideaSerializable): \Generator
    {
        $logger = app(WorkflowLoggerInterface::class);

        # region ACTIVITY INIT
        $checkPaymentActivity = Workflow::newActivityStub(
            CheckPaymentActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        $rejectedAfterTimeActivity = Workflow::newActivityStub(
            RejectedAfterTimeActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        # endregion

        # region WORKFLOW
        /** Проверка оплаты **/
        $checkPaymentActivityResult = yield $checkPaymentActivity->run($ideaSerializable);

        # Ожидание
        yield Workflow::timer(\DateInterval::createFromDateString(self::WAIT_TIME . ' minutes'));

        /** Отмена идеи **/
        $rejectedAfterTimeActivityResult = yield $rejectedAfterTimeActivity->run(
            $ideaSerializable,
            self::WAIT_TIME,
        );

        /** Проверка оплаты **/
        $checkPaymentActivityResult2 = yield $checkPaymentActivity->run($ideaSerializable);
        # endregion

        $logger->debug(
            'Workflow completed: ',
            [$checkPaymentActivityResult, $rejectedAfterTimeActivityResult, $checkPaymentActivityResult2],
        );
    }
}
