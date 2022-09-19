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

    public function getAll(): Collection
    {
        return $this->model::query()
            ->with('genres')
            ->get();
    }

    public function getOne($id): ?Game
    {
        return $this->model::query()
            ->with('genres')
            ->where('id', '=', $id)
            ->first();
    }

    public function createGame(array $game): Game
    {
        return $this->model::create($game);
    }

    public function update(int $id, array $game): Game|Bool
    {
        $model = $this->find($id);

        if ($model) {
            $model->update($game);
        }

        return $model;
    }

    public function attachGenre(int $gameId, array $data): Game|Collection|null
    {
        $game = $this->find($gameId);

        if ($game) {
            $genres = Genre::find($data['genres']);

            $game->genres()->attach($genres);
        }

        return $game ? $game->genres : null;
    }

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
