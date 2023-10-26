<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieList extends Model
{
    use HasFactory;

    protected $table = 'movie_lists';
    // Specify the correct table name if it differs from the model's plural form

    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie()
    {
        return $this->belongsToMany(Movie::class);
    }
}
