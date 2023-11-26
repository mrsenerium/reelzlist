<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ListMovie extends Pivot
{
    use HasFactory;

    protected $table = 'list_movie';

    public function movieList()
    {
        return $this->belongsTo(MovieList::class, 'list_id');
    }

    public function movie()
    {
        return $this->belongsToMany(Movie::class, 'movie_id');
    }
}
