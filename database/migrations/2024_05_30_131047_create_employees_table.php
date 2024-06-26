<?php

use App\Enums\RoleEnum;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('password');
            $table->foreignId('position_id')->references('id')->on('positions');
            $table->foreignId('shift_id')->references('id')->on('shifts');
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->enum('role', (new RoleEnum)->getAllConstants())->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
