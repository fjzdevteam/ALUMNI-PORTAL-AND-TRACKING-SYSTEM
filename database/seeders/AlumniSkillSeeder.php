<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumniSkillSeeder extends Seeder
{
    public function run(): void
    {
        $alumniSkills = [
            // 🧑‍💻 Zyra (user_id=2) - BSCS / Programming
            ['user_id' => 2, 'skill_id' => 113], // Java
            ['user_id' => 2, 'skill_id' => 105], // MySQL
            ['user_id' => 2, 'skill_id' => 124], // OOP Concepts
            ['user_id' => 2, 'skill_id' => 118], // RESTful APIs
            ['user_id' => 2, 'skill_id' => 176], // Agile Methodology
            ['user_id' => 2, 'skill_id' => 139], // Software Engineering


            // 💻 Lexie (user_id=3) - BSIT / Frontend Dev
            ['user_id' => 3, 'skill_id' => 106], // HTML
            ['user_id' => 3, 'skill_id' => 107], // CSS
            ['user_id' => 3, 'skill_id' => 103], // JavaScript
            ['user_id' => 3, 'skill_id' => 102], // Laravel
            ['user_id' => 3, 'skill_id' => 101], // PHP
            ['user_id' => 3, 'skill_id' => 198], // Responsive Design


            // 📊 Mark (user_id=4) - Accounting
            ['user_id' => 4, 'skill_id' => 250], // Financial Accounting
            ['user_id' => 4, 'skill_id' => 253], // Auditing
            ['user_id' => 4, 'skill_id' => 258], // Financial Reporting
            ['user_id' => 4, 'skill_id' => 262], // Microsoft Excel
            ['user_id' => 4, 'skill_id' => 269], // Cash Flow Management


            // 📈 Clara (user_id=5) - Marketing
            ['user_id' => 5, 'skill_id' => 278], // Digital Marketing
            ['user_id' => 5, 'skill_id' => 280], // Social Media Marketing
            ['user_id' => 5, 'skill_id' => 304], // Google Analytics
            ['user_id' => 5, 'skill_id' => 273], // Market Research
            ['user_id' => 5, 'skill_id' => 283], // Business Presentation


            // 🧠 Joshua (user_id=6) - Entrepreneurship
            ['user_id' => 6, 'skill_id' => 290], // Business Plan Development
            ['user_id' => 6, 'skill_id' => 291], // Negotiation and Sales
            ['user_id' => 6, 'skill_id' => 308], // Product Development
            ['user_id' => 6, 'skill_id' => 313], // Pitch Presentation
            ['user_id' => 6, 'skill_id' => 319], // Innovation Strategy


            // 🏨 Samantha (user_id=7) - Hospitality Management
            ['user_id' => 7, 'skill_id' => 43],  // Customer Focus
            ['user_id' => 7, 'skill_id' => 13],  // Interpersonal Skills
            ['user_id' => 7, 'skill_id' => 16],  // Empathy
            ['user_id' => 7, 'skill_id' => 284], // Customer Service
            ['user_id' => 7, 'skill_id' => 72],  // Client Relations


            // 👩‍🏫 Kevin (user_id=8) - Education
            ['user_id' => 8, 'skill_id' => 382], // Lesson Planning
            ['user_id' => 8, 'skill_id' => 384], // Classroom Management
            ['user_id' => 8, 'skill_id' => 385], // Student Assessment
            ['user_id' => 8, 'skill_id' => 389], // Educational Technology
            ['user_id' => 8, 'skill_id' => 403], // Writing Instruction


            // 🧑‍💼 Michelle (user_id=9) - HR / Psychology
            ['user_id' => 9, 'skill_id' => 514], // Organizational Psychology
            ['user_id' => 9, 'skill_id' => 515], // Industrial Psychology
            ['user_id' => 9, 'skill_id' => 563], // Human Relations Management
            ['user_id' => 9, 'skill_id' => 873], // Employee Engagement
            ['user_id' => 9, 'skill_id' => 483], // Counseling Skills


            // ⚙️ Carla (user_id=10) - ECE / Engineering
            ['user_id' => 10, 'skill_id' => 583], // Circuit Design
            ['user_id' => 10, 'skill_id' => 586], // Microcontroller Programming
            ['user_id' => 10, 'skill_id' => 588], // PCB Design
            ['user_id' => 10, 'skill_id' => 596], // Control Systems
            ['user_id' => 10, 'skill_id' => 602], // Engineering Drawing


            // 🏥 Miguel (user_id=11) - Nursing
            ['user_id' => 11, 'skill_id' => 680], // Patient Care
            ['user_id' => 11, 'skill_id' => 681], // Vital Signs Monitoring
            ['user_id' => 11, 'skill_id' => 682], // Medication Administration
            ['user_id' => 11, 'skill_id' => 685], // Wound Care
            ['user_id' => 11, 'skill_id' => 687], // Infection Control


            // 🧑‍💼 Angela (user_id=12) - Business Admin
            ['user_id' => 12, 'skill_id' => 274], // Sales Strategy
            ['user_id' => 12, 'skill_id' => 278], // Digital Marketing
            ['user_id' => 12, 'skill_id' => 283], // Business Presentation
            ['user_id' => 12, 'skill_id' => 291], // Negotiation
            ['user_id' => 12, 'skill_id' => 295], // Risk Management


            // 👨‍💻 John (user_id=13) - IT / Software Engineering
            ['user_id' => 13, 'skill_id' => 101], // PHP
            ['user_id' => 13, 'skill_id' => 102], // Laravel
            ['user_id' => 13, 'skill_id' => 103], // JavaScript
            ['user_id' => 13, 'skill_id' => 105], // MySQL
            ['user_id' => 13, 'skill_id' => 121], // Git
        ];

        DB::table('alumni_skill')->insert($alumniSkills);
    }
}
