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
        Schema::create('alumni_first_employment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('company_name')->nullable();
            $table->string('position_title')->nullable();
            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations', 'location_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('industry_id')
                ->nullable()
                ->constrained('industries', 'industry_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->enum('job_alignment', ['highly-related', 'somewhat-related', 'not related'])->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'self-employed', 'freelance'])->nullable();
            $table->enum('waiting_period', ['0-3 months', '4-6 months', '7-12 months', 'over 1 year'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_first_employment');
    }
};
