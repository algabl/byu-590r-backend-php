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
        Schema::create('temple_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temple_id')->constrained('temples')->onDelete('cascade');
            $table->string('architect')->nullable();
            $table->integer('square_footage')->nullable();
            $table->integer('number_ordinance_rooms')->nullable();
            $table->integer('number_sealing_rooms')->nullable();
            $table->integer('number_surface_parking_spots')->nullable();
            $table->text('additional_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temple_details');
    }
};
