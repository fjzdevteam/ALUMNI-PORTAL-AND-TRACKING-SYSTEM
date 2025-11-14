<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_first_employment', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });

        Schema::table('alumni_current_employment', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });

        Schema::table('alumni_past_employment', function (Blueprint $table) {
            $table->boolean('visible')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('alumni_first_employment', function (Blueprint $table) {
            $table->dropColumn('visible');
        });

        Schema::table('alumni_current_employment', function (Blueprint $table) {
            $table->dropColumn('visible');
        });

        Schema::table('alumni_past_employment', function (Blueprint $table) {
            $table->dropColumn('visible');
        });
    }
};
