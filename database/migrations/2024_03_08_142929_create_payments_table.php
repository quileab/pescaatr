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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // team id
            $table->foreignIdFor(\App\Models\team::class)
                ->constrained();
            // payment date
            $table->timestamp('date');
            // amount
            $table->decimal('amount', 10, 2);
            // notes
            $table->text('notes');
            // created at - updated at
            $table->index(['team_id']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
