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
        Schema::table('destinasis', function (Blueprint $table) {
            $table->unsignedInteger('place_id')->nullable()->unique()->after('id');
            $table->integer('time_minutes')->nullable()->after('harga_tiket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasis', function (Blueprint $table) {
            $table->dropColumn(['place_id', 'time_minutes']);
        });
    }
};