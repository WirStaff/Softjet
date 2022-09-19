<?php

namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository extends Repository
{
    /**
     * @var Genre
     */
    protected $model = Genre::class;

    public function getAll(): Collection
    {
        return $this->model::query()
            ->with('games')
            ->get();
    }

    public function getOne($id): ?Genre
    {
        return $this->model::query()
            ->with('games')
            ->find($id);
    }

    public function create(array $genre): Genre
    {
        return $this->model::create($genre);
    }

    public function update(int $id, array $game): Genre|Bool
    {
        $model = $this->find($id);

        if ($model) {
            $model->update($game);
        }

        return $model;
    }

    public function delete(int $id): Genre|Bool
    {
        $genre = $this->find($id);

        if ($genre) {
            $genre->delete();
        }

        return $genre;
    }
}
