<?php
/**
 * Web Routes
 *
 * PHP Version 8.1
 *
 * @category Routes
 * @package  Routes
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get(
    '/',
    function () {
        return view('home');
    }
);

/**
 * Setting Routes
 * @phpcs:disable
 */
Route::post('/search', [SearchController::class, 'results'])->name('pages.search.results');
Route::get('/search', [SearchController::class, 'movie'])->name('pages.search');
Route::get('/movie/{tmdbid}/tmdb', [MovieController::class, 'single'])->name('pages.tmdb');
Route::get('/movie/{id}', [MovieController::class, 'single'])->name('pages.singleMovie');
Route::any('/login', [UserController::class, 'login'])->name('login');
Route::any('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'storeRegistration'])->name('storeRegistration');
