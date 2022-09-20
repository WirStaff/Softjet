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

    /**
     *  @OA\Post(
     *      path = "/genres",
     *      tags = { "Genres" },
     *      summary = "Добавить жанр",
     *      description = "Добавить жанр",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Шутер"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Жанр создан",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
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
     *      path="/genres",
     *      tags={"Genres"},
     *      summary="Возвращает весь список жанров",
     *      description="Возвращает весь список жанров",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
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
     *      path="/genres/{id}",
     *      tags={"Genres"},
     *      summary="Возвращает жанр",
     *      description="Возвращает жанр",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID жанра",
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
        $genre = $this->repositry->getOne($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }

    /**
     * @OA\Put(
     *      path="/genres/{id}",
     *      tags={"Genres"},
     *      summary="Обновить жанр",
     *      description="Обновить жанр",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID жанра",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Шутер"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Genre")
     *      ),
     *      @OA\Response(response=404, description="Жанр не найден"),
     *      @OA\Response(response=422, description="Ошибка проверки данных"),
     * )
     * @param int $id
     * @param Update $request
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function update(int $id, Update $request): JsonResponse
    {
        $genre = $this->repositry->update($id, $request->input());

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }

    /**
     * @OA\Delete  (
     *      path="/genres/{id}",
     *      tags={"Genres"},
     *      summary="Удалить жанр",
     *      description="Удалить жанр",
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID жанра",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Жанр удален"),
     *      @OA\Response(response=404, description="Жанр не найден"),
     * )
     * @param int $id
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function destroy(int $id): JsonResponse
    {
        $genre = $this->repositry->delete($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        return $this->success($genre);
    }
}
