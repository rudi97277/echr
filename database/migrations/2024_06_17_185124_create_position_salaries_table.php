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
        Schema::create('position_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->references('id')->on('positions');
            $table->string('salary_code');
            $table->decimal('amount', 15, 0);
            $table->timestamps();
            $table->foreign('salary_code')->references('code')->on('salaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_salaries');
    }
};
