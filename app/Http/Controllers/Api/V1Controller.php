<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Тестовое задание для Softjet",
 *     description="Тестовое задание",
 *     version="0.1"
 * )
 * @OA\Server(
 *     description="Сервер версия 1",
 *     url="http://127.0.0.1:8080/api/v1"
 * )
 * @OA\Response(
 *      response=404,
 *      description="Не найдена сущность",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="message",
 *              type="string"
 *          )
 *      )
 * )
 * @OA\Response(
 *      response=406,
 *      description="Ошибка валидации переданных параметров",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property="message",
 *              type="string"
 *          )
 *      )
 * )
 */
class V1Controller extends Controller
{
    public function success($data = []): JsonResponse
    {
        return response()->json($data);
    }
}
