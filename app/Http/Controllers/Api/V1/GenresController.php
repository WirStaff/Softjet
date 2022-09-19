<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1Controller;
use App\Http\Requests\Genres\Store;
use App\Http\Requests\Genres\Update;
use App\Repositories\GenreRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenresController extends V1Controller
{
    private $repositry;

    public function __construct(GenreRepository $repository)
    {
        $this->repositry = $repository;
    }

    public function store(Store $request): JsonResponse
    {
        $game = $this->repositry->create($request->input());
        return $this->success($game);
    }

    public function index(): JsonResponse
    {
        return $this->success($this->repositry->getAll());
    }

    public function show(int $id): JsonResponse
    {
        $genre = $this->repositry->getOne($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }

    public function update(int $id, Update $request): JsonResponse
    {
        $genre = $this->repositry->update($id, $request->input());

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }

    public function destroy(int $id): JsonResponse
    {
        $genre = $this->repositry->delete($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }
}
