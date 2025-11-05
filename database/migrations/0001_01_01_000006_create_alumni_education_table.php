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
        Schema::create('alumni_education', function (Blueprint $table) {
            $table->id('education_id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('student_number', 50)->nullable();
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses', 'course_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->year('year_graduated')->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_education');
    }
};
