<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\AbstractApiController;
use App\Facades\GenreFacade;

class GenreController extends AbstractApiController
{
    /**
     * Display a listing of genres.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responseData = GenreFacade::all();

        return $this->responseJSON(
            __('genres.response.200.all'),
            200,
            $responseData,
        );
    }
}
