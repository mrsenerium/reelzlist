<?php

namespace App\Models;

use App\Http\Resources\OMDbConnection;
use App\Http\Resources\TMDbConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use stdClass;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($movie) {
            $movie->slug = Str::slug($movie->id . '-' . $movie->title);
        });

        static::retrieved(function ($movie) {
            if ($movie->slug === null) {

                $movie->slug = Str::slug($movie->id . '-' . $movie->title);

                $movie->save();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function MovieList()
    {
        return $this->belongsToMany(MovieList::class);
    }

    public function updateTMDBData($force = false): void
    {
        if ($this->updated_at <= Carbon::now()->subMonth() || $force) {
            $tmdbData = (new TMDbConnection)->singleMovieData($this->tmdb_id);

            $this->update([
                'title' => $tmdbData->title ?? null,
                'overview' => $tmdbData->overview ?? null,
                'imdb_id' => $tmdbData->imdb_id ?? null,
                'runtime' => $tmdbData->runtime ?? null,
                'box_office' => $tmdbData->revenue ?? null,
                'budget' => $tmdbData->budget ?? null,
                'release_date' => $tmdbData->release_date,
                'tmdb_id' => $tmdbData->id,
            ]);
        }
    }

    public function updateOMDBData()
    {
        $omdbData = (new OMDbConnection)->getSingleMovie($this->imdb_id);

        $this->update([
            'poster_url' => $omdbData->Poster ?? null,
            'mpaa_rating' => $omdbData->Rated ?? null,
            'imdb_rating' => $omdbData->Ratings[0]->Value ?? null,
            'tomatometer' => $omdbData->Ratings[1]->Value ?? null,
            'metacritic_rating' => $omdbData->Ratings[2]->Value ?? null,
        ]);
    }
    // }

    //I need to check if there is a tmdb_id
    // $oneMonthAgo = Carbon::now()->subMonth();
    // $updatedAt = Carbon::parse($this->updated_at);

    // if (
    //     $updatedAt->lte($oneMonthAgo)
    //     || $this->imdb_id === null
    //     || $this->runtime === null
    //     || $this->box_office === null
    //     || $this->budget === null
    // ) {
    //     //die('second boom');
    //     $tmdb = new TMDbConnection;
    //     $tmdbData = $tmdb->singleMovieData($this->tmdb_id);
    //     $this->imdb_id = isset($tmdbData->imdb_id) ?
    //         $tmdbData->imdb_id : $this->imdb_id;
    //     $this->runtime = isset($tmdbData->runtime) ?
    //         $tmdbData->runtime : $this->runtime;
    //     $this->box_office = isset($tmdbData->revenue) ?
    //         $tmdbData->revenue : $this->boxoffice;
    //     $this->budget = isset($tmdbData->budget) ?
    //         $tmdbData->budget : $this->budget;
    //     $this->save();
    // }

    // if ($this->mpaa_rating === null || $this->poster_url === null) {
    //     //die('boom');
    //     $omdb = new OMDbConnection;
    //     $omdbData = $omdb->getSingleMovie($this->imdb_id);

    //     //echo '<pre>';
    //     //var_dump($omdbData);die('</pre>');
    //     $this->poster_url = isset($omdbData->Poster) ?
    //         $omdbData->Poster : $this->poster_url;
    //     $this->mpaa_rating = isset($omdbData->Rated) ?
    //         $omdbData->Rated : $this->mpaa_rating;
    //     if (isset($omdbData->Ratings)) {
    //         foreach ($omdbData->Ratings as $key => $rating) {
    //             switch ($rating->Source) {
    //                 case 'Internet Movie Database':
    //                     $this->imdb_rating = $rating->Value;
    //                     break;
    //                 case 'Rotten Tomatoes':
    //                     $this->tomatometer = $rating->Value;
    //                     break;
    //                 case 'Metacritic':
    //                     $this->metacritic_rating = $rating->Value;
    //                     break;
    //             }
    //         }
    //     }
    //     $this->save();
    // }

    public function getWatchProviders($tmdb_id): stdClass
    {
        $tmdb = new TMDbConnection;
        $providers = $tmdb->getWatchProviders($tmdb_id);
        $return = '';

        if (isset($providers->results->US)) {
            $return = $providers->results;
        } else {
            $return = new stdClass;
            $return->found = null;
        }

        return $return;
    }
}
