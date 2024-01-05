<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\BaseRepository;

class MovieRepository extends BaseRepository
{
    const ITEMS_ON_PAGE = 8;

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
     * Inits requests for getting movies, appropriate to the filters
     *
     * @param object $request
     * @return object
     */
    private function initRequest(object $request)
    {
        $query = $this->model;

        if ($request->exists('search') && strlen($request->search) > 0) {
            $query = $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->exists('genre') && strlen($request->genre) > 0) {
            $query = $query->where('genre_id', 'like', "{$request->genre}");
        }

        if ($request->exists('year') && strlen($request->year) > 0) {
            $query = $query->where('year', 'like', "%{$request->year}%");
        }

        return $query;
    }

    /**
     * Gets movies, appropriate to the pagination
     *
     * @param object $request
     * @return object|null
     */
    public function getMovies(object $request): object
    {
        return $this->initRequest($request)->paginate(self::ITEMS_ON_PAGE);
    }
}
