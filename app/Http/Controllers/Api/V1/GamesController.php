<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1Controller;
use App\Http\Requests\Games\Attach;
use App\Http\Requests\Games\Detach;
use App\Http\Requests\Games\Store;
use App\Http\Requests\Games\Update;
use App\Repositories\GameRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GamesController extends V1Controller
{
    private $repositry;

    public function __construct(GameRepository $repository)
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
        $game = $this->repositry->getOne($id);

        if (!$game) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($game);
    }

    public function update(int $id, Update $request): JsonResponse
    {
        $game = $this->repositry->update($id, $request->input());

        if (!$game) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($game);
    }

    public function destroy(int $id): JsonResponse
    {
        $game = $this->repositry->delete($id);

        if (!$game) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($game);
    }

    public function genreAttach(int $id, Attach $request): JsonResponse
    {
        $result = $this->repositry->attachGenre($id, $request->input());

        if (!$result) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($result);
    }

    public function genreDetach(int $id, Detach $request): JsonResponse
    {
        $result = $this->repositry->detachGenre($id, $request->input());

        if (!$result) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($result);
    }
}
