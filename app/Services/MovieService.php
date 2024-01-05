<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\MovieRepository;

class MovieService extends BaseService
{
    /**
    * Constructor.
    *
    * @var MovieRepository $repo
    */
    public function __construct(MovieRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Gets movies, appropriate to the pagination
     *
     * @param object $request
     * @return object|null
     */
    public function getMovies(object $request): object|null
    {
        return $this->repo->getMovies($request);
    }
}
