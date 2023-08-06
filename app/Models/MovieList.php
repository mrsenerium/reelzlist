<?php
/**
 * MovieList Model
 *
 * PHP Version 8.1
 *
 * @category Model
 * @package  App\Models\Model
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MovieList Model
 *
 * @category Model
 * @package  App\Models\Model
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
class MovieList extends Model
{
    protected $table = 'movie_lists';
    // Specify the correct table name if it differs from the model's plural form

    protected $fillable = ['user_id', 'name'];

    /**
     * Define the relationship with the User model
     *
     * @return void
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the many-to-many relationship with the Movie model
     * through the list_movie pivot table
     *
     * @return void
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'list_movie')->withTimestamps();
    }
}
