<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Get the reviews for the movie.
     *
    public function reviews()
    {
        return $this->hasMany(MovieReview::class);
    }*/
}
