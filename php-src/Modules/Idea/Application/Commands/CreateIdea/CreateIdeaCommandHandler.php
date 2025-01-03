<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Commands\CreateIdea;

use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use Modules\Idea\Domain\Service\WorkflowLauncherInterface;
use Modules\Shared\Application\Command\CommandHandlerInterface;
use Modules\Shared\Application\Command\CommandInterface;

final readonly class CreateIdeaCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        protected IdeaRepositoryInterface $repository,
        protected IdeaFactoryInterface $factory,
        protected WorkflowLauncherInterface $workflowLauncher,
    ) {}

    public function __invoke(CreateIdeaCommand|CommandInterface $command): string
    {
        $idea = $this->factory->create(
            $command->getTitle(),
            $command->getDescription(),
            $command->getPrice(),
            $command->getCurrency(),
        );
        $this->repository->save($idea);
        $this->workflowLauncher->startPayForIdeaWorkflow($idea);
        return $idea->getId()->getValue();
    }
}
