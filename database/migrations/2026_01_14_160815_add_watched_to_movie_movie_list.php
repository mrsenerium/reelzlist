<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movie_movie_list', function (Blueprint $table) {
            $table->boolean('watched')->default(false)->after('movie_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_movie_list', function (Blueprint $table) {
            $table->dropColumn('watched');
        });
    }
};
