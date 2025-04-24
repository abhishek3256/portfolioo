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
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('founder_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->date('founding_date')->nullable();
            $table->string('industry');
            $table->enum('stage', ['idea', 'pre-seed', 'seed', 'early', 'growth', 'mature'])->default('idea');
            $table->decimal('funding_amount', 15, 2)->default(0);
            $table->integer('employee_count')->default(1);
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive', 'acquired', 'closed'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};