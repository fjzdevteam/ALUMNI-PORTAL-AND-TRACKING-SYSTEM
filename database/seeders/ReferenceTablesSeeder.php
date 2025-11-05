<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReferenceTablesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Seed colleges table
        DB::table('colleges')->insert([
            [
                'department_code' => 'CON',
                'department_name' => 'College of Nursing',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'COE',
                'department_name' => 'College of Engineering',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'COED',
                'department_name' => 'College of Education',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'CCS',
                'department_name' => 'College of Computer Studies',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'CAS',
                'department_name' => 'College of Arts and Science',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'CBA',
                'department_name' => 'College of Business and Accountancy',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_code' => 'CIHM',
                'department_name' => 'College of Hospitality Management',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        // Seed courses table
        DB::table('courses')->insert([
            [
                'department_id' => 6,
                'course_code' => 'BSA',
                'course_name' => 'BS Accountancy',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 6,
                'course_code' => 'BSBA',
                'course_name' => 'BS Administration Major in Marketing Management',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 6,
                'course_code' => 'BSENT',
                'course_name' => 'BS Entrepreneurship',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 7,
                'course_code' => 'BSHM',
                'course_name' => 'BS Hospitality Management',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 3,
                'course_code' => 'BEED',
                'course_name' => 'Bachelor of Elementary Education',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 3,
                'course_code' => 'BSED-ENG',
                'course_name' => 'Bachelor of Secondary Education Major in English',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 3,
                'course_code' => 'BSED-FIL',
                'course_name' => 'Bachelor of Secondary Education Major in Filipino',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 3,
                'course_code' => 'BSED-MATH',
                'course_name' => 'Bachelor of Secondary Education Major in Math',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 3,
                'course_code' => 'BEED-GEN',
                'course_name' => 'Bachelor of Elementary Education Major in General Education',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 5,
                'course_code' => 'AB Psych',
                'course_name' => 'AB Psychology',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 4,
                'course_code' => 'BSCS',
                'course_name' => 'BS Computer Science',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 4,
                'course_code' => 'BSIT',
                'course_name' => 'BS Information Technology',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 2,
                'course_code' => 'BSECE',
                'course_name' => 'BS Electronics Engineering',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'department_id' => 1,
                'course_code' => 'BSN',
                'course_name' => 'BS Nursing',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        // Seed industries table
        DB::table('industries')->insert([
            ['industry_name' => 'Agriculture', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Banking and Finance', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Business Process Outsourcing (BPO)', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Construction', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Education', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Engineering', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Entertainment and Media', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Government', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Healthcare and Medical', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Hospitality and Tourism', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Information Technology (IT)', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Legal Services', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Manufacturing', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Maritime and Logistics', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Mining', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Non-Governmental Organization (NGO)', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Oil and Gas', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Real Estate', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Retail and E-commerce', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Science and Research', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Telecommunications', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Transportation', 'created_at' => $now, 'updated_at' => $now],
            ['industry_name' => 'Utilities (Water, Power, Energy)', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed locations table
        DB::table('locations')->insert([
            ['region_name' => 'NCR - National Capital Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'CAR - Cordillera Administrative Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region I - Ilocos Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region II - Cagayan Valley', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region III - Central Luzon', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region IV-A - CALABARZON', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'MIMAROPA - Southwestern Tagalog Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region V - Bicol Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region VI - Western Visayas', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region VII - Central Visayas', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region VIII - Eastern Visayas', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region IX - Zamboanga Peninsula', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region X - Northern Mindanao', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region XI - Davao Region', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region XII - SOCCSKSARGEN', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Region XIII - Caraga', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'BARMM - Bangsamoro Autonomous Region in Muslim Mindanao', 'created_at' => $now, 'updated_at' => $now],
            ['region_name' => 'Outside of the Philippines', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed event_types table
        DB::table('event_types')->insert([
            ['event_type_name' => 'Alumni Homecoming', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Job Fair', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Career Seminar', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Networking Event', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Reunion', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Webinar', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Workshop', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Awarding Ceremony', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'Outreach Program', 'created_at' => $now, 'updated_at' => $now],
            ['event_type_name' => 'General Assembly', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed event_types table
        DB::table('forum_categories')->insert([
            ['category_name' => 'Announcements', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Academics & Career', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Events & Activities', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'General Discussion', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Feedback & Suggestions', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
