<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'user_profiles',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                // Add additional columns for user profile information
                $table->string('given_name')->nullable();
                $table->string('family_name')->nullable()->default(null);
                $table->date('birthdate')->nullable()->default(null);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
