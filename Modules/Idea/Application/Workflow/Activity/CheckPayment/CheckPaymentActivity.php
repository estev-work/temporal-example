<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity\CheckPayment;

use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityMethod;
use Temporal\Exception\Client\ActivityCompletionFailureException;

final readonly class CheckPaymentActivity implements CheckPaymentActivityInterface
{
    public function __construct(
        private WorkflowLoggerInterface $logger,
        private IdeaRepositoryInterface $repository,
        private IdeaFactoryInterface $factory,
    ) {}

    #[ActivityMethod(name: 'Проверка оплаты идеи')]
    public function run(string $ideaSerializable): string
    {
        try {
            $idea = $this->factory->unserialize($ideaSerializable);
            $price = $idea->getPrice()->getRawAmount();
            
            if ($price > 0) {
                $status = IdeaStatus::approved();
                $title = "[APPROVED]:{$idea->getTitle()}";
            } else {
                $status = IdeaStatus::rejected();
                $title = "[REJECTED]:{$idea->getTitle()}";
            }

            $idea->changeStatus($status);
            $idea->changeTitle(new IdeaTitle($title));
            $this->repository->save($idea);

            $this->logger->info("Статус идеи {$idea->getTitle()->getValue()} изменён на {$status->getValue()->value}");

            return $idea->getId()->getValue();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ActivityCompletionFailureException($exception->getMessage());
        }
    }
}
