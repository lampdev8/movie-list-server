<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\GenreRepository;

class GenreService extends BaseService
{
    /**
    * Constructor.
    *
    * @var GenreRepository $repo
    */
    public function __construct(GenreRepository $repo)
    {
        $this->repo = $repo;
    }
}
