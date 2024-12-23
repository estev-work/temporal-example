<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity;

use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Application\WorkflowLoggerInterface;
use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;
use Temporal\Exception\Client\ActivityCompletionFailureException;

#[ActivityInterface]
final readonly class RejectedAfterTimeActivity
{
    public function __construct(
        private WorkflowLoggerInterface $logger,
        private IdeaRepositoryInterface $repository,
        private IdeaFactoryInterface $factory,
    ) {}

    #[ActivityMethod(name: 'Отмена идеи через время')]
    public function run(string $ideaSerializable, int $minutes): string
    {
        try {
            $idea = $this->factory->unserialize($ideaSerializable);

            $idea->changeStatus(IdeaStatus::rejected());
            $idea->changeTitle(new IdeaTitle("[REJECTED]:{$idea->getTitle()->getValue()}"));
            $this->repository->save($idea);

            $this->logger->info("Идея :{$idea->getTitle()->getValue()}. Отменена спустя {$minutes} минут");

            return $idea->getId()->getValue();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new ActivityCompletionFailureException($exception->getMessage());
        }
    }
}
