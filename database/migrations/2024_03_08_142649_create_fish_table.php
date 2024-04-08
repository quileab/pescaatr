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
        Schema::create('fish', function (Blueprint $table) {
            $table->id();
            // team_id relationship
            $table->foreignIdFor(\App\Models\Team::class, 'team_id')
                ->constrained()
                ->onDelete('cascade');
            // species relationship
            $table->foreignIdFor(\App\Models\Species::class, 'species_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('size')->unsigned();
            $table->integer('weight')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fish');
    }
};
