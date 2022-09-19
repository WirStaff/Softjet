<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    /** @var Model $model */
    protected $model;

    public function getAll()
    {
        return app($this->model)::all();
    }

    public function find(int $id)
    {
        $items = app($this->model)::query()->where('id', $id)->get(['*']);

        return $items ? current(current($items)) : null;
    }
}
