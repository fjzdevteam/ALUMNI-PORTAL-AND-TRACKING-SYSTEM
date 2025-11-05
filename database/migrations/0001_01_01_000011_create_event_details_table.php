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
        Schema::create('event_details', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_title');
            $table->foreignId('event_type_id')
                ->nullable()
                ->constrained('event_types', 'event_type_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();


            $table->date('event_date');
            $table->time('event_time');
            $table->time('event_end_time')->nullable();
            $table->string('location');
            $table->text('event_description');
            $table->enum('status', ['upcoming', 'done'])->default('upcoming');
            $table->date('rsvp_deadline')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('event_date_posted')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_details');
    }
};
