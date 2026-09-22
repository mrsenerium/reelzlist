<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeMovieTitleLike(Builder $query, ?string $movieTitle): Builder
    {
        return $query->when($movieTitle, function (Builder $query) use ($movieTitle) {
            $query->whereHas('movie', function (Builder $query) use ($movieTitle) {
                $query->where('title', 'like', '%'.$movieTitle.'%');
            });
        });
    }

    public function scopeReviewTitleLike(Builder $query, ?string $reviewTitle): Builder
    {
        return $query->when($reviewTitle, function (Builder $query) use ($reviewTitle) {
            $query->where('name', 'like', '%'.$reviewTitle.'%');
        });
    }

    public function scopeRating(Builder $query, ?int $rating): Builder
    {
        return $query->when($rating, function (Builder $query) use ($rating) {
            $query->where('rating', $rating);
        });
    }
}
