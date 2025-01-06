<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Factory;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\ValueObject\IdeaDescription;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Application\Logger\AppLoggerInterface;
use Modules\Shared\Domain\ValueObject\CurrencyEnum;
use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\ValueObject\MoneyValue;

final readonly class IdeaFactory implements IdeaFactoryInterface
{
    public function __construct(
        private IdentifierInterface $identifierPrototype,
        private AppLoggerInterface $logger,
    ) {}

    public function create(
        string $title,
        string $description,
        float $price,
        string $currency,
    ): Idea {
        return new Idea(
            $this->generateIdentifier(),
            new IdeaTitle($title),
            new IdeaDescription($description),
            IdeaStatus::new(),
            new MoneyValue($price, CurrencyEnum::from($currency)),
            Carbon::now()->toISOString(),
            null,
        );
    }

    private function generateIdentifier(): IdentifierInterface
    {
        return $this->identifierPrototype::generate();
    }

    private function makeIdentifier(string $id): IdentifierInterface
    {
        return $this->identifierPrototype::make($id);
    }

    /**
     * @throws Exception
     */
    public function fromArray(array $data): Idea
    {
        Log::channel('workflow')->debug($data);
        if (!count($data)) {
            throw new Exception('Array must contain at least one value');
        }
        $status = match ($data['status']) {
            'approved' => IdeaStatus::approved(),
            'rejected' => IdeaStatus::rejected(),
            'closed' => IdeaStatus::closed(),
            default => IdeaStatus::new(),
        };
        $this->logger->debug('fromArray', $data);
        return new Idea(
            $this->makeIdentifier($data['id']),
            new IdeaTitle($data['title']),
            new IdeaDescription($data['description']),
            $status,
            new MoneyValue($data['price'], CurrencyEnum::from($data['currency'])),
            $data['createdAt'] ?? null,
            $data['updatedAt'] ?? null,

        );
    }
}
