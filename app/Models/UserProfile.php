<?php
/**
 * UserProfile Model
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
 * UserProfile Model
 *
 * @category Model
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */
class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'family_name',
        'birthdate',
    ];

    /**
     * Boot function on initial load
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set the default value for full_name when creating a new profile
        static::creating(
            function ($profile) {
                if (! $profile->given_name) {
                    // Set it to the username of the associated user
                    $profile->given_name = $profile->user->name;
                }
            }
        );
    }

    /**
     * Define the relationship with the User model
     *
     * @return UserProfile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
