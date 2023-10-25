<?php
/**
 * Movie Migrations
 *
 * PHP Version 8.1
 *
 * @category Core_Migrations
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table(
            'movies', function (Blueprint $table) {
                $table->string('mpaa_rating')->nullable();
                $table->string('tomatometer')->nullable();
                $table->string('imdb_rating')->nullable();
                $table->string('metacritic_rating')->nullable();
            }
        );
    }

    public function down()
    {
        Schema::table(
            'movies', function (Blueprint $table) {
                $table->dropColumn('mpaa_rating');
                $table->dropColumn('tomatometer');
                $table->dropColumn('imdb_rating');
                $table->dropColumn('metacritic_rating');
            }
        );
    }
};
