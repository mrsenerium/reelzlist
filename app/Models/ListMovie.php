<?php
/**
 * ListMovie Model
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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * ListMovie Model
 *
 * @category Model
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */
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
