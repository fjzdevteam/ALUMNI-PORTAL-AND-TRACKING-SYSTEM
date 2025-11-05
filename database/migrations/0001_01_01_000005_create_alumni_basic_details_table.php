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
        Schema::create('alumni_basic_details', function (Blueprint $table) {
            $table->id('alumni_id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->enum('employment_status', ['full-time', 'part-time', 'self-employed', 'freelance', 'unemployed']);
            $table->date('birthdate');
            $table->string('sex', 10);
            $table->string('civil_status', 50)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->text('about')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_basic_details');
    }
};
