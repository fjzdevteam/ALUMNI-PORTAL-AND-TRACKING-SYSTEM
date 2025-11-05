<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{


    public function up(): void
    {
        Schema::create('job_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')
                ->constrained('job_details', 'job_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->foreignId('skill_id')
                ->nullable()
                ->constrained('skills')
                ->nullOnDelete()
                ->onUpdate('cascade');


            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('job_skill');
    }
};
