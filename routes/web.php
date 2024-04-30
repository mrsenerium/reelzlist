<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TmdbDataController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StaticPagesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

//Create group for static pages routes no prefix staticPagesController
Route::group([], function () {
    Route::get('/features', [StaticPagesController::class, 'features'])->name('features');
    Route::get('/about', [StaticPagesController::class, 'about'])->name('about');
    Route::get('/contact', [StaticPagesController::class, 'contact'])->name('contact');
    Route::get('/', [StaticPagesController::class, 'home'])->name('home');
});



Route::resource('movies', MovieController::class);
Route::resource('tmdb', TmdbDataController::class);
Route::resource('movie-lists', MovieListController::class);
Route::resource('users', UserController::class);
Route::resource('profile', ProfileController::class);
Route::resource('review', ReviewController::class)->except(['create']);
Route::get('review/create/{user_id}/{movie_id}', [ReviewController::class, 'create'])->name('review.create');

Route::any('movie-lists/add/{movieList}/{movie}', [MovieListController::class, 'addMovieToList'])->name('movie-lists.add');
Route::get('movie-lists/remove/{movieList}/{movie}', [MovieListController::class, 'removeMovieFromList'])->name('movie-lists.remove');

Route::any('login', [UserController::class, 'login'])->name('login');
Route::any('logout', [UserController::class, 'logout'])->name('logout');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'storeRegistration'])->name('storeRegistration');
