<?php
/**
 * User Profile Migrations
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
    public function up(): void
    {
        Schema::create(
            'movie_lists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->string('name');
                $table->boolean('private')->default(false);
                // Add any other list-related columns you may need
                $table->timestamps();

                // Define the foreign key relationship with the users table
                $table
                    ->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_lists');
    }
};
