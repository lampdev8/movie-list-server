<?php

use App\Facades\LocalizationFacade;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use App\Facades\PosterFacade;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => LocalizationFacade::locale(), 'middleware' => ['set_locale', 'cors']], function($router) {
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function ($router) {
        Route::post('logout', 'AuthController@logout')->middleware('jwt')->name('auth_logout_v1');
        Route::get('me', 'AuthController@me')->middleware('jwt')->name('auth_me_v1');
        Route::post('login', 'AuthController@login')->name('auth_login_v1');
        Route::post('refresh', 'AuthController@refresh')->name('auth_refresh_token_v1');
    });

    Route::prefix('movies')->group(function () {
        Route::resource('/', MovieController::class)->except([
            'index',
            'show',
            'update',
            'destroy',
        ]);
        Route::get('/', [MovieController::class, 'index'])->name('movies');
        Route::get('/{id}', [MovieController::class, 'show'])->name('movie_show');
        Route::put('/{id}', [MovieController::class, 'update'])->name('movie_update');
        Route::delete('/{id}', [MovieController::class, 'destroy'])->name('movie_delete');
    });

    Route::get('images/posters/{poster_name}', function($poster_name = null)
    {
        $path = 'images/posters/' . $poster_name;
        return PosterFacade::getPoster($path);
    });
});
