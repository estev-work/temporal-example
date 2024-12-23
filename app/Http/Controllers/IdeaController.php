<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Idea\Application\Commands\CreateIdea\CreateIdeaCommand;
use Modules\Idea\Application\Queries\GetIdeaById\GetIdeaByIdQuery;
use Modules\Shared\Application\Bus\CommandBusInterface;
use Modules\Shared\Application\Bus\QueryBusInterface;

final class IdeaController extends Controller
{
    private CommandBusInterface $commandBus;
    private QueryBusInterface $queryBus;

    public function __construct(
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * Создать новую идею
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'price' => 'required|decimal:2',
                'currency' => 'required|string|size:3',
            ]);

            // Отправляем команду на создание
            $command = new CreateIdeaCommand(
                title: $validatedData['title'],
                description: $validatedData['description'],
                price: (float)$validatedData['price'],
                currency: $validatedData['currency'],
            );

            $this->commandBus->dispatch($command);
            return response()->json(['message' => 'Idea created successfully'], 201);
        } catch (\Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Получить идею по ID
     *
     * @param string $id
     * @return JsonResponse
     */
    public function getById(string $id): JsonResponse
    {
        // Выполняем запрос
        $query = new GetIdeaByIdQuery($id);
        $idea = $this->queryBus->ask($query);

        if ($idea === null) {
            return response()->json(['message' => 'Idea not found'], 404);
        }

        // Преобразование идеи в JSON
        return response()->json([
            'id' => $idea->id, // Пример структуры. Замените на свои поля.
            'title' => (string)$idea->title,
            'description' => (string)$idea->description,
            'status' => (string)$idea->status,
            'price' => $idea->price->getAmount(),
            'currency' => (string)$idea->price->currency,
        ]);
    }
}
