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

    /**
     *  @OA\Post(
     *      path = "/games",
     *      tags = { "Games" },
     *      summary = "Добавить игру",
     *      description = "Добавить игру",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="Counter Strike 1.6"),
     *              @OA\Property(property="description", type="string", example="The best game")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Игра создана",
     *          @OA\JsonContent(ref="#/components/schemas/Game")
     *      ),
     *      @OA\Response(response=422, description="Ошибка проверки данных")
     *  )
     *  @param Store $request
     *  @return JsonResponse
     */
    public function store(Store $request): JsonResponse
    {
        $game = $this->repositry->create($request->input());
        return $this->success($game);
    }

    /**
     * @OA\Get(
     *      path="/games",
     *      tags={"Games"},
     *      summary="Возвращает весь список игр",
     *      description="Возвращает весь список игр",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Game")
     *      ),
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success($this->repositry->getAll());
    }

    /**
     * @OA\Get(
     *      path="/games/{id}",
     *      tags={"Games"},
     *      summary="Возвращает игру",
     *      description="Возвращает игру",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID игры",
     *          required=true,
     *          @OA\Schema(type="id")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
     *      ),
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $game = $this->repositry->getOne($id);

        if (!$game) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($game);
    }

    /**
     * @OA\Put(
     *      path="/games/{id}",
     *      tags={"Games"},
     *      summary="Обновить игру",
     *      description="Обновить игру",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID игры",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="Counter Strike 1.6"),
     *              @OA\Property(property="description", type="string", example="The best game")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Game")
     *      ),
     *      @OA\Response(response=404, description="Игра не найдена"),
     *      @OA\Response(response=422, description="Ошибка проверки данных"),
     * )
     * @param int $id
     * @param Update $request
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function update(int $id, Update $request): JsonResponse
    {
        $game = $this->repositry->update($id, $request->input());

        if (!$game) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($game);
    }

    /**
     * @OA\Delete  (
     *      path="/games/{id}",
     *      tags={"Games"},
     *      summary="Удалить игру",
     *      description="Удалить игру",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID игры",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Игра удалена"),
     *      @OA\Response(response=404, description="Игра не найдена"),
     * )
     * @param int $id
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function destroy(int $id): JsonResponse
    {
        $game = $this->repositry->delete($id);

        return $this->success($game);
    }

    /**
     *  @OA\Post(
     *      path = "/games/genres/{id}/attach",
     *      tags = { "Games" },
     *      summary = "Добавить в игру жанр",
     *      description = "Добавить в игру жанр",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"generes"},
     *              @OA\Property(property="generes", type="integer", example="[1, 2]"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Жанр добавлен",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
     *      ),
     *      @OA\Response(response=404, description="Игра не найдена")
     *  )
     *  @param int $id
     *  @param Attach $request
     *  @return JsonResponse
     *  @throws NotFoundHttpException
     */
    public function genreAttach(int $id, Attach $request): JsonResponse
    {
        $result = $this->repositry->attachGenre($id, $request->input());

        if (!$result) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($result);
    }

    /**
     * @OA\Post(
     *      path = "/games/genres/{id}/detach",
     *      tags = { "Games" },
     *      summary = "Удалить из игры жанр",
     *      description = "Удалить из игры жанр",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"generes"},
     *              @OA\Property(property="generes", type="integer", example="[1, 2]"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Жанр удален",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
     *      ),
     *      @OA\Response(response=404, description="Игра не найдена")
     *  )
     * @param int $id
     * @param Detach $request
     * @return JsonResponse
     */
    public function genreDetach(int $id, Detach $request): JsonResponse
    {
        $result = $this->repositry->detachGenre($id, $request->input());

        if (!$result) {
            throw new NotFoundHttpException('Игра не найдена');
        }

        return $this->success($result);
    }
}
