<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($user) {
            Profile::create([
                'user_id' => $user->id,
                'given_name' => str_contains($user->name, ' ')
                    ? explode(' ', $user->name)[0]
                    : $user->name,
                'family_name' => str_contains($user->name, ' ')
                    ? explode(' ', $user->name)[1]
                    : $user->name,
            ]);
        });
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super-admin' || $this->id === 1;
    }

    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'super-admin' || $this->id === 1;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function movie_list() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(MovieList::class, 'user_id');
    }

    public function suggestMovies(?string $genre, ?int $year, bool $hideWatched, int $limit = 3): Collection
    {
        $query = Movie::query()
            ->whereHas('movieList', function ($query) use ($hideWatched) {
                $query->where('movie_lists.user_id', $this->id);

                if ($hideWatched) {
                    $query->where('movie_movie_list.is_watched', false);
                }
            });

        if ($genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('genres.name', $genre);
            });
        }

        if ($year) {
            $query->where('release_date', 'like', $year.'%');
        }

        return $query
            ->with([
                'genres',
                'movieList' => function ($query) {
                    $query->where('movie_lists.user_id', $this->id);
                },
            ])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function listedGenres(): Collection
    {
        return Genre::query()
            ->whereHas('movies', function ($query) {
                $query->whereHas('movieList', function ($query) {
                    $query->where('movie_lists.user_id', $this->id);
                });
            })
            ->orderBy('name')
            ->get();
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function help()
    {
        return $this->hasMany(Help::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'user_subscription');
    }
}
