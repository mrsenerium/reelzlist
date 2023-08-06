<?php
/**
 * ListMovie Model
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
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * ListMovie Model
 *
 * @category Model
 * @package  App\Models\Model
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
class ListMovie extends Pivot
{
    use HasFactory;

    protected $table = 'list_movie';
}
