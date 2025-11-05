<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class JobSkillSeeder extends Seeder
{
    public function run(): void
    {
        $jobSkills = [


            // 1️⃣ Web Developer (PLDT Inc.)
            ['job_id' => 1, 'skill_id' => 106], // HTML
            ['job_id' => 1, 'skill_id' => 107], // CSS
            ['job_id' => 1, 'skill_id' => 103], // JavaScript
            ['job_id' => 1, 'skill_id' => 102], // Laravel
            ['job_id' => 1, 'skill_id' => 101], // PHP
            ['job_id' => 1, 'skill_id' => 105], // MySQL
            ['job_id' => 1, 'skill_id' => 121], // Git
            ['job_id' => 1, 'skill_id' => 139], // Software Engineering
            ['job_id' => 1, 'skill_id' => 198], // Responsive Design


            // 2️⃣ Java Programmer (Globe Telecom)
            ['job_id' => 2, 'skill_id' => 113], // Java
            ['job_id' => 2, 'skill_id' => 135], // Data Structures
            ['job_id' => 2, 'skill_id' => 136], // Algorithms
            ['job_id' => 2, 'skill_id' => 118], // RESTful APIs
            ['job_id' => 2, 'skill_id' => 124], // OOP Concepts
            ['job_id' => 2, 'skill_id' => 139], // Software Engineering
            ['job_id' => 2, 'skill_id' => 176], // Agile Methodology
            ['job_id' => 2, 'skill_id' => 190], // SQL Queries
            ['job_id' => 2, 'skill_id' => 185], // SDLC


            // 3️⃣ Marketing Coordinator (SM Retail Inc.)
            ['job_id' => 3, 'skill_id' => 278], // Digital Marketing
            ['job_id' => 3, 'skill_id' => 280], // Social Media Marketing
            ['job_id' => 3, 'skill_id' => 304], // Google Analytics
            ['job_id' => 3, 'skill_id' => 281], // Brand Management
            ['job_id' => 3, 'skill_id' => 273], // Market Research
            ['job_id' => 3, 'skill_id' => 283], // Business Presentation
            ['job_id' => 3, 'skill_id' => 274], // Sales Strategy
            ['job_id' => 3, 'skill_id' => 305], // Email Marketing
            ['job_id' => 3, 'skill_id' => 282], // Product Promotion


            // 4️⃣ Junior Accountant (PwC Philippines)
            ['job_id' => 4, 'skill_id' => 250], // Financial Accounting
            ['job_id' => 4, 'skill_id' => 253], // Auditing
            ['job_id' => 4, 'skill_id' => 254], // Taxation
            ['job_id' => 4, 'skill_id' => 258], // Financial Reporting
            ['job_id' => 4, 'skill_id' => 262], // Microsoft Excel
            ['job_id' => 4, 'skill_id' => 263], // Accounting Software
            ['job_id' => 4, 'skill_id' => 269], // Cash Flow Management
            ['job_id' => 4, 'skill_id' => 260], // Financial Analysis
            ['job_id' => 4, 'skill_id' => 264], // QuickBooks


            // 5️⃣ Business Development Associate (Ayala Land Inc.)
            ['job_id' => 5, 'skill_id' => 290], // Business Plan Development
            ['job_id' => 5, 'skill_id' => 295], // Risk Management
            ['job_id' => 5, 'skill_id' => 291], // Negotiation and Sales
            ['job_id' => 5, 'skill_id' => 308], // Product Development
            ['job_id' => 5, 'skill_id' => 313], // Pitch Presentation
            ['job_id' => 5, 'skill_id' => 319], // Innovation Strategy
            ['job_id' => 5, 'skill_id' => 320], // Supply Chain Analysis
            ['job_id' => 5, 'skill_id' => 289], // Entrepreneurial Thinking
            ['job_id' => 5, 'skill_id' => 341], // Leadership in Business


            // 6️⃣ Guest Relations Officer (Shangri-La The Fort)
            ['job_id' => 6, 'skill_id' => 43],  // Customer Focus
            ['job_id' => 6, 'skill_id' => 13],  // Interpersonal Skills
            ['job_id' => 6, 'skill_id' => 16],  // Empathy
            ['job_id' => 6, 'skill_id' => 284], // Customer Service
            ['job_id' => 6, 'skill_id' => 72],  // Client Relations
            ['job_id' => 6, 'skill_id' => 46],  // Constructive Feedback
            ['job_id' => 6, 'skill_id' => 86],  // Stress Tolerance
            ['job_id' => 6, 'skill_id' => 47],  // Positive Attitude
            ['job_id' => 6, 'skill_id' => 35],  // Dependability


            // 7️⃣ High School English Teacher (Pasig City Science High)
            ['job_id' => 7, 'skill_id' => 382], // Lesson Planning
            ['job_id' => 7, 'skill_id' => 383], // Curriculum Development
            ['job_id' => 7, 'skill_id' => 384], // Classroom Management
            ['job_id' => 7, 'skill_id' => 385], // Student Assessment
            ['job_id' => 7, 'skill_id' => 389], // Educational Technology
            ['job_id' => 7, 'skill_id' => 402], // Reading Comprehension Instruction
            ['job_id' => 7, 'skill_id' => 403], // Writing Instruction
            ['job_id' => 7, 'skill_id' => 405], // Pronunciation Training
            ['job_id' => 7, 'skill_id' => 407], // Grammar Instruction


            // 8️⃣ Human Resource Assistant (Nestlé Philippines)
            ['job_id' => 8, 'skill_id' => 514], // Organizational Psychology
            ['job_id' => 8, 'skill_id' => 515], // Industrial Psychology
            ['job_id' => 8, 'skill_id' => 563], // Human Relations Management
            ['job_id' => 8, 'skill_id' => 873], // Employee Engagement
            ['job_id' => 8, 'skill_id' => 43],  // Customer Focus (Internal)
            ['job_id' => 8, 'skill_id' => 483], // Counseling Skills
            ['job_id' => 8, 'skill_id' => 486], // Personality Assessment
            ['job_id' => 8, 'skill_id' => 523], // Confidentiality Management
            ['job_id' => 8, 'skill_id' => 520], // Counseling Ethics


            // 9️⃣ Electronics Design Engineer (Samsung)
            ['job_id' => 9, 'skill_id' => 583], // Circuit Design
            ['job_id' => 9, 'skill_id' => 586], // Microcontroller Programming
            ['job_id' => 9, 'skill_id' => 588], // PCB Design
            ['job_id' => 9, 'skill_id' => 595], // Analog Circuit Analysis
            ['job_id' => 9, 'skill_id' => 596], // Control Systems
            ['job_id' => 9, 'skill_id' => 600], // Matlab Simulation
            ['job_id' => 9, 'skill_id' => 602], // Engineering Drawing
            ['job_id' => 9, 'skill_id' => 624], // Energy Efficiency Design
            ['job_id' => 9, 'skill_id' => 649], // Engineering Ethics


            // 🔟 Registered Nurse (St. Luke’s Medical Center)
            ['job_id' => 10, 'skill_id' => 680], // Patient Care
            ['job_id' => 10, 'skill_id' => 681], // Vital Signs Monitoring
            ['job_id' => 10, 'skill_id' => 682], // Medication Administration
            ['job_id' => 10, 'skill_id' => 685], // Wound Care
            ['job_id' => 10, 'skill_id' => 687], // Infection Control
            ['job_id' => 10, 'skill_id' => 688], // Nursing Documentation
            ['job_id' => 10, 'skill_id' => 689], // Patient Education
            ['job_id' => 10, 'skill_id' => 700], // Oxygen Therapy
            ['job_id' => 10, 'skill_id' => 715], // Nursing Ethics
        ];


        DB::table('job_skill')->insert($jobSkills);
    }
}
