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
        Schema::create('attendance_penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->references('id')->on('attendances');
            $table->integer('in_minutes');
            $table->decimal('amount', 15, 0);
            $table->boolean('is_corrected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_penalties');
    }
};
