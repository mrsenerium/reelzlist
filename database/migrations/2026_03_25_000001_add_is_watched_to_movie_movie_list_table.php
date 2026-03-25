<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movie_movie_list', function (Blueprint $table) {
            $table->boolean('is_watched')->default(false)->after('movie_id');
        });
    }

    public function down(): void
    {
        Schema::table('movie_movie_list', function (Blueprint $table) {
            $table->dropColumn('is_watched');
        });
    }
};
