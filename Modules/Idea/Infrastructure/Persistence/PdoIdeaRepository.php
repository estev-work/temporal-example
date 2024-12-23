<?php

declare(strict_types=1);

namespace Modules\Idea\Infrastructure\Persistence;

use Modules\Idea\Domain\Factory\IdeaFactoryInterface;
use Modules\Idea\Domain\Idea;
use Modules\Idea\Domain\Repository\IdeaRepositoryInterface;
use PDO;

final class PdoIdeaRepository implements IdeaRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Idea $idea): void
    {
        $stmt = $this->pdo->prepare(
            '
            INSERT INTO ideas (id, title, description, status, price, currency)
            VALUES (:id, :title, :description, :status, :price, :currency)
            ON CONFLICT (id) DO UPDATE SET
                title = EXCLUDED.title,
                description = EXCLUDED.description,
                status = EXCLUDED.status,
                price = EXCLUDED.price,
                currency = EXCLUDED.currency
        ',
        );

        $stmt->execute([
            'id' => (string)$idea->getId(),
            'title' => (string)$idea->getTitle(),
            'description' => (string)$idea->getDescription(),
            'status' => (string)$idea->getStatus(),
            'price' => $idea->getPrice()->getRawAmount(),
            'currency' => $idea->getPrice()->currency->value,
        ]);
    }

    public function findById(string $id): ?Idea
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ideas WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrateIdea($data);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM ideas');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ideas = [];
        foreach ($rows as $row) {
            $ideas[] = $this->hydrateIdea($row);
        }

        return $ideas;
    }

    private function hydrateIdea(array $data): Idea
    {
        /** @var IdeaFactoryInterface $factory */
        $factory = app(IdeaFactoryInterface::class);
        return $factory->fromArray($data);
    }
}
