<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\TMDbConnection;
use App\Http\Resources\OMDbConnection;
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
        //I need to check if there is a tmdb_id
        $oneMonthAgo = Carbon::now()->subMonth();
        $updatedAt = Carbon::parse($this->updated_at);

        if ($updatedAt->lte($oneMonthAgo) || 
          $this->imdb_id === null || 
          $this->runtime === null || 
          $this->box_office === null || 
          $this->budget === null) {
            //die('second boom');
            $tmdb = new TMDbConnection();
            $tmdbData = $tmdb->single_movie_data($this->tmdb_id);
            $this->imdb_id = isset($tmdbData->imdb_id) ? $tmdbData->imdb_id : $this->imdb_id;
            $this->runtime = isset($tmdbData->runtime) ? $tmdbData->runtime : $this->runtime;
            $this->box_office = isset($tmdbData->revenue) ? $tmdbData->revenue : $this->boxoffice;
            $this->budget = isset($tmdbData->budget) ? $tmdbData->budget : $this->budget;
            $this->save();
        }
        if ($this->mpaa_rating === null || $this->poster_url === null)
        {
            //die('boom');
            $omdb = new OMDbConnection();
            $omdbData = $omdb->search($this->imdb_id);
            
            //echo '<pre>';
            //var_dump($omdbData);die('</pre>');
            $this->poster_url = isset($omdbData->Poster) ? $omdbData->Poster : $this->poster_url;
            $this->mpaa_rating = isset($omdbData->Rated) ? $omdbData->Rated : $this->mpaa_rating;
            foreach($omdbData->Ratings as $key => $rating) {
                switch ($rating->Source) {
                    case "Internet Movie Database":
                        $this->imdb_rating = $rating->Value;
                        break;
                    case "Rotten Tomatoes":
                        $this->tomatometer = $rating->Value;
                        break;
                    case "Metacritic":
                        $this->metacritic_rating = $rating->Value;
                        break;
                }
            }
            $this->save();
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
