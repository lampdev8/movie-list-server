<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\AbstractApiController;
use Illuminate\Http\Request;
use App\Facades\MovieFacade;
use App\Facades\PosterFacade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MovieController extends AbstractApiController
{
    /**
     * Display a listing of movies.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $responseData = MovieFacade::getMovies($request);

        return $this->responseJSON(
            __('movies.response.200.all'),
            200,
            $responseData,
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'title' => ['required'],
                'year' => ['required'],
                'poster' => ['required'],
            ])->validate();

            $nowDate = new \DateTime('now');

            $posterUrl = PosterFacade::uploadPoster($request->poster);

            MovieFacade::create([
                'title' => $request->title,
                'year' => $request->year,
                'poster' => $posterUrl,
                'created_at' => $nowDate,
                'updated_at' => $nowDate,
            ]);

            return $this->responseJSON(
                __('movies.response.200.store'),
                200,
                [],
            );
        } catch (\Exception $e) {
            Log::error($e);

            return $this->responseJSON(
                __('movies.response.500'),
                500,
                [],
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $movie = MovieFacade::find($id);

            return $this->responseJSON(
                __('movies.response.200.show'),
                200,
                $movie ?? [],
            );
        } catch (\Exception $e) {
            Log::error($e);

            return $this->responseJSON(
                __('movies.response.500'),
                500,
                [],
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $nowDate = new \DateTime('now');

            $dataToUpdate = [
                'title' => $request->title,
                'year' => $request->year,
                'updated_at' => $nowDate,
            ];

            $poster = PosterFacade::checkChanges($id, $request->poster);

            if ($poster) {
                $dataToUpdate['poster'] = $poster;
            }

            MovieFacade::update($id, $dataToUpdate);

            return $this->responseJSON(
                __('movies.response.200.update'),
                200,
                [],
            );
        } catch (\Exception $e) {
            Log::error($e);

            return $this->responseJSON(
                __('movies.response.500'),
                500,
                [],
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
