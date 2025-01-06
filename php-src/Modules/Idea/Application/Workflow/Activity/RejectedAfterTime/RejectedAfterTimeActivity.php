<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity\RejectedAfterTime;

use Modules\Idea\Application\Workflow\Data\IdeaTemporalData;
use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Temporal\Activity\ActivityMethod;
use Temporal\Exception\Client\ActivityCompletionFailureException;

final readonly class RejectedAfterTimeActivity implements RejectedAfterTimeActivityInterface
{
    public function __construct(
        private AppLoggerInterface $logger,
        private IdeaRepositoryInterface $repository,
        private IdeaFactoryInterface $factory,
    ) {
        $this->logger->channel = LoggerChannelEnum::ACTIVITY;
    }

    #[ActivityMethod(name: 'RejectedAfterTime')]
    public function rejectedAfterTime(IdeaTemporalData $ideaData, int $minutes): string
    {
        try {
            $idea = $this->factory->fromArray($ideaData->toArray());
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
