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
        Schema::create('tourism_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_dataset_id');
            $table->unsignedInteger('place_id');
            $table->unsignedTinyInteger('place_rating');
            $table->timestamps();

            $table->index('user_dataset_id');
            $table->index('place_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_ratings');
    }
};