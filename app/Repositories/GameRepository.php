<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GameRepository extends Repository
{
    /**
     * @var Game
     */
    protected $model = Game::class;

    /**
     * Получает список всех игр
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::query()
            ->with('genres')
            ->get();
    }

    /**
     * Получение игры
     *
     * @param int $id
     * @return ?Game
     */
    public function getOne(int $id): ?Game
    {
        return $this->model::query()
            ->with('genres')
            ->find($id);
    }

    /**
     * Создание игры
     *
     * @param array $game
     * @return Game
     */
    public function create(array $game): Game
    {
        return $this->model::create($game);
    }

    /**
     * Обновление игры
     *
     * @param int $id
     * @param array $game
     * @return Game|Bool
     */
    public function update(int $id, array $game): Game|Bool
    {
        $model = $this->find($id);

        if ($model) {
            $model->update($game);
        }

        return $model;
    }

    /**
     * Удаление игры
     *
     * @param int $id
     * @return Game|Bool
     */
    public function delete(int $id): Game|Bool
    {
        $game = $this->find($id);

        if ($game) {
            $game->delete();
        }

        return $game;
    }

    /**
     * Привязка жанра к игре
     *
     * @param int $gameId
     * @param array $data
     * @return Game|Collection|null
     */
    public function attachGenre(int $gameId, array $data): Game|Collection|null
    {
        $game = $this->find($gameId);

        if ($game) {
            $genres = Genre::find($data['genres']);

            $game->genres()->attach($genres);
        }

        return $game ? $game->genres : null;
    }

    /**
     * Отвязка жанра от игры
     *
     * @param int $gameId
     * @param array $data
     * @return Game|Collection|null
     */
    public function detachGenre(int $gameId, array $data): Game|Collection|null
    {
        $game = $this->find($gameId);

        if ($game) {
            $genres = Genre::find($data['genres']);

            $game->genres()->detach($genres);
        }

        return $game ? $game->genres : null;
    }
}
