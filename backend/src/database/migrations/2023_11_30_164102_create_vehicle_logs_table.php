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
        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('charged');
            $table->datetime('entryAt');
            $table->datetime('outAt')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //TODO: Drop foreign keys
        Schema::dropIfExists('vehicle_logs');
    }
};
