<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'movie_movie_list',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('movie_list_id');
                $table->foreignId('movie_id');
                // Add any other list-related columns you may need
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_movie_list');
    }
};
