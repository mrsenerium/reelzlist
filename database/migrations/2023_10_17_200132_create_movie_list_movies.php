<?php
/**
 * User Profile Migrations
 *
 * PHP Version 8.1
 *
 * @category Core_Migrations
 * @package  Migrations
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'movie_movie_list', function (Blueprint $table) {
                $table->id();
                $table->foreignId('movie_list_id');
                $table->foreignId('movie_id');
                // Add any other list-related columns you may need
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_movie_list');
    }
};
