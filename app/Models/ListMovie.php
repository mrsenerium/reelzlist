<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ListMovie extends Pivot
{
    use HasFactory;

    protected $table = 'movie_movie_list';

    protected $fillable = [
        'is_watched',
    ];

    protected $casts = [
        'is_watched' => 'boolean',
    ];

    public function movieList(): BelongsTo
    {
        return $this->belongsTo(MovieList::class, 'movie_list_id');
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
