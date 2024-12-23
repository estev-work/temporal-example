<?php

declare(strict_types=1);

namespace Modules\Idea\Domain\Factory;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\ValueObject\IdeaDescription;
use Modules\Idea\Domain\ValueObject\IdeaStatus;
use Modules\Idea\Domain\ValueObject\IdeaTitle;
use Modules\Shared\Domain\ValueObject\CurrencyEnum;
use Modules\Shared\Domain\ValueObject\Identifier\IdentifierInterface;
use Modules\Shared\Domain\ValueObject\MoneyValue;

final class IdeaFactory implements IdeaFactoryInterface
{
    private IdentifierInterface $identifierPrototype;

    public function __construct(IdentifierInterface $identifierPrototype)
    {
        $this->identifierPrototype = $identifierPrototype;
    }

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
        );
    }

    public function createWithStatus(
        string $title,
        string $description,
        float $price,
        string $currency,
        IdeaStatus $status,
    ): Idea {
        return new Idea(
            $this->generateIdentifier(),
            new IdeaTitle($title),
            new IdeaDescription($description),
            $status,
            new MoneyValue($price, CurrencyEnum::from($currency)),
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
        if (!count($data)) {
            throw new Exception('Array must contain at least one value');
        }
        $status = match ($data['status']) {
            'approved' => IdeaStatus::approved(),
            'rejected' => IdeaStatus::rejected(),
            'closed' => IdeaStatus::closed(),
            default => IdeaStatus::new(),
        };
        return new Idea(
            $this->makeIdentifier($data['id']),
            new IdeaTitle($data['title']),
            new IdeaDescription($data['description']),
            $status,
            new MoneyValue($data['price'], CurrencyEnum::from($data['currency'])),

        );
    }

    /**
     * @throws Exception
     */
    public function unserialize(string $stringData): Idea
    {
        $data = json_decode($stringData, true);
        Log::channel('workflow')->debug(['str' => $stringData, 'data' => $data]);
        return $this->fromArray($data ?? []);
    }
}
