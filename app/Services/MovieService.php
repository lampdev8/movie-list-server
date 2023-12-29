<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\Storage;

class MovieService extends BaseService
{
    private const POSTERS_DIRECTORY = 'images/posters/';
    private const API_VERSION = '/api/v1/';

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

    public function uploadPosterImage(array $posterData): string
    {
        $extension = explode('/', $posterData['type'])[1];
        $poster = $posterData['file'];

        if ($extension === 'png') {
            $poster = str_replace('data:image/png;base64,', '', $poster);
        } elseif ($extension === 'jpeg') {
            $poster = str_replace('data:image/jpeg;base64,', '', $poster);
        }

        $poster = str_replace(' ', '+', $poster);
        $posterName = time() . '.' . $extension;
        $posterUrl = self::POSTERS_DIRECTORY . $posterName;

        Storage::disk('local')->put($posterUrl, base64_decode($poster));

        $host = request()->getHttpHost();

        return $host . self::API_VERSION . $posterUrl;
    }
}
