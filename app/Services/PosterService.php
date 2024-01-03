<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Facades\MovieFacade;

class PosterService
{
    private const POSTERS_DIRECTORY = 'images/posters/';

    /**
     * Gets a poster by the path from storage
     *
     * @param string $path
     * @return object|null
     */
    public function getPoster(string $path): object|null
    {
        if (Storage::disk('local')->exists($path)) {
            $response = Response::make(Storage::get($path), 200);
            $type = Storage::mimeType($path);
            $response->header("Content-Type", $type);

            return $response;
        }

        return null;
    }

    /**
     * Uploads the poster by the poster data
     *
     * @param array $posterData
     * @return string
     */
    public function uploadPoster(array $posterData): string
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

        return $posterUrl;
    }

    /**
     * Checks if the poster has been modified, and if so, downloads and links to the new file, and deletes the old file
     *
     * @param integer $id
     * @param mixed $poster
     * @return string|null
     */
    public function checkChanges(int $id, mixed $poster): string|null
    {
        if (gettype($poster) == 'array') {
            $movie = MovieFacade::find($id);
            $posterFilePath = self::POSTERS_DIRECTORY . explode(self::POSTERS_DIRECTORY, $movie->poster)[1];
            $this->remove($posterFilePath);

            return $this->uploadPoster($poster);
        }

        return null;
    }

    /**
     * Removes poster file from storage
     *
     * @param string $posterFilePath
     * @return void
     */
    public function remove(string $posterFilePath): void
    {
        if (Storage::disk('local')->exists($posterFilePath)) {
            Storage::disk('local')->delete($posterFilePath);
        }
    }
}
