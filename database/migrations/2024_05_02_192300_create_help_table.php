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
        Schema::create('helps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->default(null);
            $table->text('title');
            $table->text('message');
            $table->text('type'); // (bug, feature, question, other
            $table->boolean('want_response')->default(false); // (yes, no)
            $table->boolean('read')->default(false);
            $table->longText('response')->nullable()->default(null);
            $table->boolean('resolved')->default(false);
            $table->timestamp('resolved_at')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};
