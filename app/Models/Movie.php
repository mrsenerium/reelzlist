<?php

namespace App\Models;

use App\Http\Resources\OMDbConnection;
use App\Http\Resources\TMDbConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use stdClass;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($movie) {
            if ($movie->slug === null) {
                $movie->slug = Str::slug($movie->id.'-'.$movie->title);
                $movie->save();
            }
        });

        static::retrieved(function ($movie) {
            if ($movie->slug === null) {
                $movie->slug = Str::slug($movie->id.'-'.$movie->title);
                $movie->save();
            }
        });
        static::saved(function ($movie) {
            if ($movie->slug === null) {
                $movie->slug = Str::slug($movie->id.'-'.$movie->title);
                $movie->save();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function movieList()
    {
        return $this->belongsToMany(MovieList::class)
            ->withPivot('watched')
            ->withTimestamps();
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'movie_id');
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

    public function filterProviders($movieProviders, $userSubscriptions): collection
    {
        $providers = collect();

        foreach (['free', 'ads', 'flatrate', 'buy', 'rent'] as $providerType) {
            if (! empty($movieProviders->$providerType)) {
                $providerCollection = collect($movieProviders->$providerType);

                $matches = $providerCollection->filter(function ($provider) use ($userSubscriptions) {
                    return $userSubscriptions->contains('name', $provider->provider_name);
                });

                $providers = $providers->merge($matches);
            }
        }

        return $providers;
    }

    public function scopeFrontpageSafe($query)
    {
        return $query->where('frontpage_safe', true);
    }

    public function scopeWithPoster($query)
    {
        return $query->get()->filter(function ($movie) {
            return $movie->checkPoster();
        });
    }

    public function checkPoster()
    {
        $client = new \GuzzleHttp\Client([
            'connect_timeout' => 0.4,
            'timeout' => 0.8,
            'http_errors' => true,
        ]);

        try {
            $client->head($this->poster_url);
            return $this->poster_url;
        } catch (\Exception $e) {
            \Log::Warning([
                'message' => 'Poster not found, fetching from TMDb',
                'movie_id' => $this->id,
                'tmdb_id' => $this->tmdb_id,
                'poster_url' => $this->poster_url,
                'message' => $e->getMessage(),
            ]);
            $tmdb = (new TMDbConnection)->getPoster($this);
              $this->poster_url = $tmdb;
              $this->save();
              return $this->poster_url;
        }
    }
}
