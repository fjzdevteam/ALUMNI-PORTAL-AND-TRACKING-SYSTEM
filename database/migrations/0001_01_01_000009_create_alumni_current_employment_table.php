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
        Schema::create('alumni_current_employment', function (Blueprint $table) {
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

            $table->date('start_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_current_employment');
    }
};
