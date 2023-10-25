<?php
/**
 * MovieList Model
 *
 * PHP Version 8.1
 *
 * @category Model
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MovieList Model
 *
 * @category Model
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */
class MovieList extends Model
{
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
