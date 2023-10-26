<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
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
            UserProfile::create([
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

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function movie_list()
    {
        return $this->hasMany(MovieList::class, 'user_id');
    }
}
