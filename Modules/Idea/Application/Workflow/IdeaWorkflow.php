<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow;

use Modules\Idea\Application\Workflow\Activity\CheckPayment\CheckPaymentActivityInterface;
use Modules\Idea\Application\Workflow\Activity\RejectedAfterTime\RejectedAfterTimeActivityInterface;
use Modules\Idea\Application\Workflow\Activity\SendEmail\LogFromGolangActivityInterface;
use Modules\Idea\Application\Workflow\Data\IdeaData;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityOptions;
use Temporal\Common\RetryOptions;
use Temporal\Workflow;

readonly class IdeaWorkflow implements IdeaWorkflowInterface
{
    private const int WAIT_TIME = 1;

    #[Workflow\WorkflowMethod(name: "IdeaWorkflow")]
    public function handle(IdeaData $ideaData): \Generator
    {
        $logger = app(WorkflowLoggerInterface::class);
        $logger->debug('WORKFLOW', $ideaData->toArray());

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
        $sendEmailActivity = Workflow::newActivityStub(
            LogFromGolangActivityInterface::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(1)
                ->withRetryOptions(RetryOptions::new()->withMaximumAttempts(5)),
        );
        # endregion

        # region WORKFLOW
        /** Проверка оплаты **/
        $checkPaymentActivityResult = yield $checkPaymentActivity->checkPayment($ideaData);
        /** Лог Idea объекта на golang сервисе */
        $sendEmailActivityResult = yield $sendEmailActivity->logFromGolang($ideaData);

        /** Ожидание **/
//        yield Workflow::timer(\DateInterval::createFromDateString(self::WAIT_TIME . ' minutes'));

        /** Отмена идеи **/
        $rejectedAfterTimeActivityResult = yield $rejectedAfterTimeActivity->rejectedAfterTime(
            $ideaData,
            self::WAIT_TIME,
        );

        /** Проверка оплаты **/
        $checkPaymentActivityResult2 = yield $checkPaymentActivity->checkPayment($ideaData);
        # endregion

        $logger->debug(
            'Workflow completed: ',
            [
                $checkPaymentActivityResult,
                $sendEmailActivityResult,
                $rejectedAfterTimeActivityResult,
                $checkPaymentActivityResult2,
            ],
        );
    }
}
