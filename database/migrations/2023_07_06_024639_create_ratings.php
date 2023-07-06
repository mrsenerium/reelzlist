<?php

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
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('mpaa_rating')->nullable();
            $table->string('tomatometer')->nullable();
            $table->string('imdb_rating')->nullable();
            $table->string('metacritic_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('mpaa_rating');
            $table->dropColumn('tomatometer');
            $table->dropColumn('imdb_rating');
            $table->dropColumn('metacritic_rating');
        });
    }
};
