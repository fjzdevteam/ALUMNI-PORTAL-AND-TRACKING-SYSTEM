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
        // 1️⃣ Parent table first: Colleges
        Schema::create('colleges', function (Blueprint $table) {
            $table->id('department_id'); // BIGINT UNSIGNED
            $table->string('department_code')->nullable();
            $table->string('department_name');
            $table->timestamps();
        });

        // 2️⃣ Child table: Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id'); // BIGINT UNSIGNED
            $table->unsignedBigInteger('department_id')->nullable(); // FK column
            $table->string('course_code')->nullable();
            $table->string('course_name');
            $table->timestamps();

            // Foreign key
            $table->foreign('department_id')
                ->references('department_id')
                ->on('colleges')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        // 3️⃣ Other independent tables
        Schema::create('locations', function (Blueprint $table) {
            $table->id('location_id');
            $table->string('region_name');
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id('industry_id');
            $table->string('industry_name');
            $table->timestamps();
        });

        Schema::create('event_types', function (Blueprint $table) {
            $table->id('event_type_id');
            $table->string('event_type_name');
            $table->timestamps();
        });

        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop child tables first, then parents
        Schema::dropIfExists('courses');
        Schema::dropIfExists('colleges');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('industries');
        Schema::dropIfExists('event_types');
        Schema::dropIfExists('forum_categories');
    }
};
