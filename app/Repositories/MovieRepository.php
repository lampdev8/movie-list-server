<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MovieRepository extends BaseRepository
{
    const ITEMS_ON_PAGE = 10;

    /**
    * Constructor.
    *
    * @var Movie $model
    */
    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    /**
     * Gets movies, appropriate to the pagination
     *
     * @param object $request
     * @return object|null
     */
    public function getMovies(object $request): object
    {
        return $this->model->paginate(self::ITEMS_ON_PAGE);
    }
}
