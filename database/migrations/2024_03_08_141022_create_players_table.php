<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MARK:Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 50)->nullable();
            $table->date('dob')->required()->nullable();
            $table->string('sex')->default('m');
            $table->string('phone', 15)->nullable();
            $table->string('email', 80)->unique()->nullable();
            $table->string('city', 50)->nullable();
            $table->enum('type', ['player', 'wheel', 'A', 'B'])->default('player')->nullable();
            $table->foreignIdFor(\App\Models\Team::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};