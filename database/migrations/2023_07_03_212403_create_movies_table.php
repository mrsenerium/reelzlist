<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('imdb_id')->unique()->nullable();
            $table->string('title');
            $table->text('overview');
            $table->date('release_date');
            $table->integer('runtime')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->unsignedBigInteger('box_office')->nullable();
            $table->unsignedBigInteger('budget')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
