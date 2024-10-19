<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TmdbDataController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\MovieListMovieController;
use App\Http\Controllers\RegistrationController;
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
Route::resource('help', HelpController::class);
Route::resource('review', ReviewController::class);
Route::resource('registration', RegistrationController::class);
Route::resource('movie-lists.movies', MovieListMovieController::class)->only(['store', 'destroy']);

Route::any('login', [UserController::class, 'login'])->name('login');
Route::any('logout', [UserController::class, 'logout'])->name('logout');
