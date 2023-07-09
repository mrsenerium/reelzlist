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
Route::get('/search/{tmdbid}', [SearchController::class, 'searchTmdbid']);
Route::get('/movie/{id}', [MovieController::class, 'single'])->name('pages.singleMovie');
