<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get(
    '/',
    function () {
        return view('home');
    }
);

// Route::post('search', [SearchController::class, 'results'])->name('pages.search.results');
// Route::get('search', [SearchController::class, 'movie'])->name('pages.search');

Route::get('movie', [MovieController::class, 'index'])->name('movies.index');
Route::get('movie/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');

// Route::get('movie/{tmdbid}/tmdb', [MovieController::class, 'single'])->name('pages.tmdb');

Route::any('movie-lists/add/{movieList}/{movie}', [MovieListController::class, 'addMovieToList'])->name('movie-lists.add');
Route::any('movie-lists/{movieList}/{movie}', [MovieListController::class, 'removeMovieFromList'])->name('movie-lists.remove');

Route::resource('movie-lists', MovieListController::class)->names([
    'index' => 'movie-lists.index',
    'create' => 'movie-lists.create',
    'store' => 'movie-lists.store',
    'show' => 'movie-lists.show',
    'edit' => 'movie-lists.edit',
    'update' => 'movie-lists.update',
    'destroy' => 'movie-lists.destroy',
]);

Route::any('login', [UserController::class, 'login'])->name('login');
Route::any('logout', [UserController::class, 'logout'])->name('logout');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'storeRegistration'])->name('storeRegistration');
Route::get('profile', [UserProfileController::class, 'show'])->name('showProfile');
Route::any('profile/update', [UserProfileController::class, 'update'])->name('update.profile');
