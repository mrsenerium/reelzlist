<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieList extends Model
{
    use HasFactory;

    protected $table = 'movie_lists';
    // Specify the correct table name if it differs from the model's plural form

    protected $fillable = ['user_id', 'name', 'private'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie()
    {
        return $this->belongsToMany(Movie::class)
            ->withPivot('watched')
            ->withTimestamps();
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'movie_list_id');
    }

    public function addMovieToList($movie)
    {
        $movie = Movie::where('id', $movie)->firstOrFail();
        $this->movie()->attach($movie->id, ['watched' => false]);
    }

    public function removeMovieFromList($movie)
    {
        $movie = Movie::where('id', $movie)->firstOrFail();
        $this->movie()->detach($movie->id);
    }
}
