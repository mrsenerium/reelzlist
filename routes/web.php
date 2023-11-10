<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TmdbDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('movies', MovieController::class);
Route::resource('tmdb', TmdbDataController::class);

Route::resource('movie-lists', MovieListController::class);

Route::any('movie-lists/add/{movieList}/{movie}', [MovieListController::class, 'addMovieToList'])->name('movie-lists.add');
Route::get('movie-lists/remove/{movieList}/{movie}', [MovieListController::class, 'removeMovieFromList'])->name('movie-lists.remove');

Route::any('login', [UserController::class, 'login'])->name('login');
Route::any('logout', [UserController::class, 'logout'])->name('logout');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'storeRegistration'])->name('storeRegistration');
Route::get('profile', [UserProfileController::class, 'show'])->name('showProfile');
Route::any('profile/update', [UserProfileController::class, 'update'])->name('update.profile');
