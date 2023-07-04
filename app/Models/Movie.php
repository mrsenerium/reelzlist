<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\TMDbConnection;
use Carbon\Carbon;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'imdb_id',
        'title',
        'overview',
        'release_date',
        'runtime',
        'poster_url',
        'tmdb_id',
        'box_office',
        'budget',
    ];

    public function update_self ()
    {
        //if we're missing data or this is over a month old update
        //I need to check if there is a tmdb_id
        $oneMonthAgo = Carbon::now()->subMonth();
        $updatedAt = Carbon::parse($this->updated_at);

        if ($updatedAt->lte($oneMonthAgo) || 
          $this->imdb_id === null || 
          $this->runtime === null || 
          $this->box_office === null || 
          $this->budget === null) {
            $tmdb = new TMDbConnection();
            $tmdbData = $tmdb->single_movie_data($this->tmdb_id);
            $this->imdb_id = isset($tmdbData->imdb_id) ? $tmdbData->imdb_id : $this->imdb_id;
            $this->runtime = isset($tmdbData->runtime) ? $tmdbData->runtime : $this->runtime;
            $this->box_office = isset($tmdbData->revenue) ? $tmdbData->revenue : $this->boxoffice;
            $this->budget = isset($tmdbData->budget) ? $tmdbData->budget : $this->budget;
            $this->save();
        }
        if ($this->poster_url === null)
        {
            //Create OMDB connection
        }
    }

    /**
     * Get the reviews for the movie.
     *
    public function reviews()
    {
        return $this->hasMany(MovieReview::class);
    }*/
}
