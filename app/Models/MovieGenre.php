<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieGenre extends Pivot
{
    protected $table = 'movie_genre';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
