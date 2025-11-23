<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alumni_basic_details', function (Blueprint $table) {
            $table->string('cert_path')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('alumni_basic_details', function (Blueprint $table) {
            $table->dropColumn('cert_path');
        });
    }
};
