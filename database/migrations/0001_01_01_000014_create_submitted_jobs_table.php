<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submitted_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('job_title');
            $table->foreignId('industry_id')
                ->nullable()
                ->constrained('industries', 'industry_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();


            $table->string('company');
            $table->string('location');
            $table->enum('job_type', ['full-time', 'part-time']);
            $table->string('salary_range')->nullable();
            $table->text('job_description')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied'])
                ->default('pending');
            $table->timestamp('date_posted')->useCurrent();
            $table->string('application_link')->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_jobs');
    }
};
