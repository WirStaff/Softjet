<?php

use App\Http\Controllers\Api\V1\GamesController;
use App\Http\Controllers\Api\V1\GenresController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function() {
    Route::apiResource('/games', GamesController::class);
    Route::apiResource('/genres', GenresController::class);

    Route::prefix('/games/genres')->group(function() {
        Route::post('/{id}/attach', [GamesController::class, 'genreAttach']);
        Route::post('/{id}/detach', [GamesController::class, 'genreDetach']);
    });
});
