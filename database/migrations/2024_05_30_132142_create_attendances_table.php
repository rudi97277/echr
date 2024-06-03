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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->date('date');
            $table->dateTime('in_at');
            $table->string('in_image');
            $table->decimal('in_lat', 10, 8);
            $table->decimal('in_long', 11, 8);
            $table->dateTime('out_at')->nullable();
            $table->string('out_image')->nullable();
            $table->decimal('out_lat', 10, 8)->nullable();
            $table->decimal('out_long', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
