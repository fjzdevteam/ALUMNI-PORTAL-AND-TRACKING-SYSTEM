<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubmittedJobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            // -- User 2: has 2 jobs
            [
                'user_id' => 2,
                'job_title' => 'Software Developer',
                'industry_id' => 11,
                'company' => 'TechNova Solutions',
                'location' => 'Makati City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱40,000 - ₱60,000',
                'job_description' => 'Develop and maintain web applications using Laravel and Vue.js.',
                'status' => 'approved',
                'application_link' => 'https://technova.ph/careers/software-developer',
            ],
            [
                'user_id' => 2,
                'job_title' => 'Network Technician',
                'industry_id' => 21,
                'company' => 'ConnectNet Telecom',
                'location' => 'Pasay City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱30,000 - ₱45,000',
                'job_description' => 'Install, configure, and maintain network infrastructure for clients.',
                'status' => 'approved',
                'application_link' => 'https://connectnet.ph/careers/network-technician',
            ],

            // -- User 3: has 1 job
            [
                'user_id' => 3,
                'job_title' => 'Financial Analyst',
                'industry_id' => 2,
                'company' => 'MetroBank Group',
                'location' => 'Ortigas Center, Pasig City',
                'job_type' => 'full-time',
                'salary_range' => '₱35,000 - ₱50,000',
                'job_description' => 'Analyze financial data and prepare reports for management decisions.',
                'status' => 'approved',
                'application_link' => 'https://metrobank.com.ph/apply/financial-analyst',
            ],

            // -- User 4: has no job

            // -- User 5: has 3 jobs
            [
                'user_id' => 5,
                'job_title' => 'Teacher I',
                'industry_id' => 5,
                'company' => 'Pasig City Science High School',
                'location' => 'Pasig City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱25,000 - ₱35,000',
                'job_description' => 'Teach junior high school students and develop lesson plans for mathematics subjects.',
                'status' => 'approved',
                'application_link' => 'https://depedpasig.gov.ph/careers/teacher',
            ],
            [
                'user_id' => 5,
                'job_title' => 'Marketing Assistant',
                'industry_id' => 19,
                'company' => 'ShopEase Philippines',
                'location' => 'Bonifacio Global City, Taguig',
                'job_type' => 'part-time',
                'salary_range' => '₱20,000 - ₱25,000',
                'job_description' => 'Assist in digital marketing campaigns and social media management.',
                'status' => 'pending',
                'application_link' => 'https://shopease.ph/careers/marketing-assistant',
            ],
            [
                'user_id' => 5,
                'job_title' => 'Civil Engineer',
                'industry_id' => 6,
                'company' => 'BuildRight Construction Inc.',
                'location' => 'Quezon City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱45,000 - ₱70,000',
                'job_description' => 'Supervise construction projects and ensure compliance with engineering standards.',
                'status' => 'approved',
                'application_link' => 'https://buildright.ph/careers/civil-engineer',
            ],

            // -- User 6: has 1 pending job
            [
                'user_id' => 6,
                'job_title' => 'Research Assistant',
                'industry_id' => 20,
                'company' => 'Innovate Research Institute',
                'location' => 'Manila City, Metro Manila',
                'job_type' => 'part-time',
                'salary_range' => '₱18,000 - ₱25,000',
                'job_description' => 'Assist in data collection, analysis, and report writing for ongoing projects.',
                'status' => 'pending',
                'application_link' => 'https://innovateinstitute.org/careers/research-assistant',
            ],

            // -- Users 7–9: no jobs

            // -- User 10: has 1 job
            [
                'user_id' => 10,
                'job_title' => 'Customer Service Representative',
                'industry_id' => 3,
                'company' => 'TeleConnect BPO',
                'location' => 'Mandaluyong City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱22,000 - ₱30,000',
                'job_description' => 'Handle inbound customer calls and provide excellent service.',
                'status' => 'approved',
                'application_link' => 'https://teleconnect.ph/careers/csr',
            ],

            // -- User 11: has 2 jobs
            [
                'user_id' => 11,
                'job_title' => 'Marketing Assistant',
                'industry_id' => 19,
                'company' => 'ShopEase Philippines',
                'location' => 'Taguig City, Metro Manila',
                'job_type' => 'part-time',
                'salary_range' => '₱20,000 - ₱25,000',
                'job_description' => 'Assist marketing campaigns and create online content.',
                'status' => 'approved',
                'application_link' => 'https://shopease.ph/careers/marketing-assistant',
            ],
            [
                'user_id' => 11,
                'job_title' => 'Financial Analyst',
                'industry_id' => 2,
                'company' => 'MetroBank Group',
                'location' => 'Pasig City, Metro Manila',
                'job_type' => 'full-time',
                'salary_range' => '₱35,000 - ₱50,000',
                'job_description' => 'Analyze and forecast business trends.',
                'status' => 'approved',
                'application_link' => 'https://metrobank.com.ph/apply/financial-analyst',
            ],

            // -- Users 12 & 13: no jobs
        ];

        foreach ($jobs as $job) {
            DB::table('submitted_jobs')->insert([
                'user_id' => $job['user_id'],
                'job_title' => $job['job_title'],
                'industry_id' => $job['industry_id'],
                'company' => $job['company'],
                'location' => $job['location'],
                'job_type' => $job['job_type'],
                'salary_range' => $job['salary_range'],
                'job_description' => $job['job_description'],
                'status' => $job['status'],
                'date_posted' => Carbon::now()->subDays(rand(1, 15)),
                'application_link' => $job['application_link'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
