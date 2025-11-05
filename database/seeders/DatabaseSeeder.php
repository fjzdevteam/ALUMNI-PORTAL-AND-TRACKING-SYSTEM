<?php

namespace Database\Seeders;

use App\Models\AlumniBasicDetail;
use App\Models\AlumniBasicDetails;
use App\Models\AlumniCurrentEmployment;
use App\Models\AlumniEducation;
use App\Models\AlumniFirstEmployment;
use App\Models\AlumniPastEmployment;
use Illuminate\Support\Facades\DB;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            JobDetailSeeder::class,
            JobSkillSeeder::class,
        ]);
    }
}
