<?php

namespace App\Repositories;

use App\Models\Genre;
use App\Repositories\BaseRepository;

class GenreRepository extends BaseRepository
{
    /**
    * Constructor.
    *
    * @var Genre $model
    */
    public function __construct(Genre $model)
    {
        $this->model = $model;
    }
}
