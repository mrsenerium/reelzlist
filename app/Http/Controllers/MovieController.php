<?php
/**
 * Movie Controller
 *
 * PHP Version 8.1
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\Request;
use Illuminate\View\View;
use NumberFormatter;
use App\Http\Resources\TMDbConnection;
use Illuminate\Support\Facades\Auth;

/**
 * Movie Controller
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
class MovieController extends Controller
{
    /**
     * Single Movie viewing
     *
     * @param Request $request User Request
     * @param $id      Internal DB Id
     *
     * @return view
     */
    public function single(Request $request, $id) : view
    {
        if ($request->routeIs('pages.tmdb')) {
            $connection = new TMDbConnection();
            $results = $connection->singleMovieData($id);
            $movie = Movie::firstOrCreate(
                ['tmdb_id' => $id],
                ['overview'     => $results->overview,
                'release_date' =>
                    \Carbon\Carbon::parse($results->release_date)->format('Y-m-d'),
                'title'         => $results->title,
                ]
            );
        } else {
            $movie = Movie::findOrFail($id);
        }
        $movie->updateSelf();
        if (isset($movie['budget'])) {
            $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $movie['budget'] = $formatter->format((int) $movie['budget']);
            $movie['box_office'] = $formatter->format((int) $movie['box_office']);
        }

        /**
         * FOR NOW! We pull watch providers for members only
         */
        if (Auth::check()) {
            $watchProviders = $movie->getWatchProviders($movie['tmdb_id']);
            $watchProviders = isset($watchProviders->US) ?
                $watchProviders->US : null;
            $movieLists = MovieList::where('user_id', '=', Auth::user()->id)->with('movie')->get();
        } else {
            $watchProviders = null;
            $movieLists = null;
        }
        //dd($movieLists);
        // foreach ($movieLists as $movieList) {
        //     foreach ($movieList->ListMovies as $theList);{
        //         foreach ($theList as $movie) {
        //             dd($movie);
        //         }
        //     }
        // }

        return view(
            'pages.singleMovie', [
            'movie' => $movie->toArray(),
            'watchProviders' => $watchProviders,
            'movieLists' => $movieLists
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request User Request
     *
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie Indivual Movie
     *
     * @return void
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Movie $movie Indivual Movie
     *
     * @return void
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request User Request
     * @param Movie   $movie   Indivual Movie
     *
     * @return void
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie Indivual Movie
     *
     * @return void
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
