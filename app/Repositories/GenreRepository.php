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

    /**
     * Получает список всех жанров
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::query()
            ->with('games')
            ->get();
    }

    /**
     * Получение жанра
     *
     * @param int $id
     * @return ?Genre
     */
    public function getOne(int $id): ?Genre
    {
        return $this->model::query()
            ->with('games')
            ->find($id);
    }

    /**
     * Создание жанра
     *
     * @param array $genre
     * @return Genre
     */
    public function create(array $genre): Genre
    {
        return $this->model::create($genre);
    }

    /**
     * Обновление жанра
     *
     * @param int $id
     * @param array $genre
     * @return Genre|Bool
     */
    public function update(int $id, array $genre): Genre|Bool
    {
        $model = $this->find($id);

        if ($model) {
            $model->update($genre);
        }

        return $model;
    }

    /**
     * Удаление жанра
     *
     * @param int $id
     * @return Genre|Bool
     */
    public function delete(int $id): Genre|Bool
    {
        $genre = $this->find($id);

        if ($genre) {
            $genre->delete();
        }

        return $genre;
    }
}
