<?php

use App\Facades\LocalizationFacade;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

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

Route::group(['prefix' => LocalizationFacade::locale(), 'middleware' => ['set_locale']], function($router) {
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function ($router) {
        Route::post('logout', 'AuthController@logout')->middleware('jwt')->name('auth_logout_v1');
        Route::get('me', 'AuthController@me')->middleware('jwt')->name('auth_me_v1');
        Route::post('login', 'AuthController@login')->name('auth_login_v1');
        Route::post('refresh', 'AuthController@refresh')->name('auth_refresh_token_v1');
    });

    Route::prefix('movies')->group(function () {
        Route::resource('/', MovieController::class)->except([
            'index',
        ]);
        Route::get('/', [MovieController::class, 'index'])->name('movies');
    });

    Route::get('images/posters/{image_name}', function($image_name = null)
    {
        $path = 'images/posters/1703765710.png';
        if (Storage::disk('local')->exists($path)) {
            $response = Response::make(Storage::get($path), 200);
            $type = Storage::mimeType($path);
            $response->header("Content-Type", $type);

            return $response;
        }
    });
});
