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
            'list_movie', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('list_id');
                $table->unsignedBigInteger('movie_id');
                // Add any other columns you may need for this pivot table
                $table->timestamps();

                // Define the foreign key relationships
                // with the lists and movies tables
                $table
                    ->foreign('list_id')
                    ->references('id')
                    ->on('movie_lists')
                    ->onDelete('cascade');
                $table
                    ->foreign('movie_id')
                    ->references('id')
                    ->on('movies')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('list_movie');
    }
};
