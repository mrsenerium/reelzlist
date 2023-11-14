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
        Schema::create(
            'reviews',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->foreignId('movie_id');
                $table->text('body');
                $table->unsignedSmallInteger('rating')->default(0);
                $table->boolean('private')->default(false);
                // Add any other list-related columns you may need
                $table->timestamps();

                // Define the foreign key relationship with the users table
                $table->foreign('movie_id')
                    ->references('id')
                    ->on('movies')
                    ->onDelete('cascade');
                $table
                    ->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
