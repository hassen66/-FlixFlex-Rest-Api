<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['json.response']], function () {

    Route::post('register', [\App\Http\Controllers\API\RegisterController::class, 'store'])->name('register');
    Route::post('login', [\App\Http\Controllers\API\LoginController::class, 'store'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('movies', [\App\Http\Controllers\API\MovieController::class, 'index'])->name('movies.index');
        Route::get('movies/top-rated', [\App\Http\Controllers\API\MovieController::class, 'getTopRated'])->name('movies.top.rated');
        Route::get('movies/search', [\App\Http\Controllers\API\MovieController::class, 'search'])->name('movies.search');
        Route::get('movies/{id}/trailer', [\App\Http\Controllers\API\MovieController::class, 'getTrailer'])->name('movies.trailer');
        Route::get('movies/{id}', [\App\Http\Controllers\API\MovieController::class, 'show'])->name('movies.show');

        Route::get('series', [\App\Http\Controllers\API\SerieController::class, 'index'])->name('series.index');
        Route::get('series/top-rated', [\App\Http\Controllers\API\SerieController::class, 'getTopRated'])->name('series.top.rated');
        Route::get('series/search', [\App\Http\Controllers\API\SerieController::class, 'search'])->name('series.search');
        Route::get('series/{id}/trailer', [\App\Http\Controllers\API\SerieController::class, 'getTrailer'])->name('series.trailer');
        Route::get('series/{id}', [\App\Http\Controllers\API\SerieController::class, 'show'])->name('series.show');

        Route::get('favorites', [\App\Http\Controllers\API\FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('movies/{movieId}/favorites', [\App\Http\Controllers\API\MovieFavoriteController::class, 'store'])->name('favorites.movies.store');
        Route::delete('movies/{movieId}/favorites/{id}', [\App\Http\Controllers\API\MovieFavoriteController::class, 'destroy'])->name('favorites.movies.destroy');

        Route::post('series/{serieId}/favorites', [\App\Http\Controllers\API\SerieFavoriteController::class, 'store'])->name('favorites.series.store');
        Route::delete('series/{serieId}/favorites/{id}', [\App\Http\Controllers\API\SerieFavoriteController::class, 'destroy'])->name('favorites.series.destroy');
    });
});
