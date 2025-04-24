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
        Schema::create('funding_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('startup_id')->constrained()->onDelete('cascade');
            $table->enum('round_type', ['pre-seed', 'seed', 'series_a', 'series_b', 'series_c', 'series_d', 'other']);
            $table->decimal('amount', 15, 2);
            $table->text('investors')->nullable();
            $table->date('date');
            $table->decimal('valuation', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_rounds');
    }
};