<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobDetail;

class JobDetailSeeder extends Seeder
{
    public function run(): void
    {
        // 1. IT - BSIT/BSCS
        JobDetail::create([
            'job_title' => 'Web Developer',
            'industry_id' => 11,
            'company' => 'PLDT Inc.',
            'location' => 'Pasig City',
            'job_type' => 'full-time',
            'salary_range' => '30,000 - 40,000',
            'job_description' => 'Develop and maintain responsive websites using HTML, CSS, JavaScript, Laravel, and PHP. Collaborate with designers and backend teams to create user-friendly systems. Knowledge in database design (MySQL) and version control (Git) is required. Strong problem-solving, communication, and teamwork skills are essential.',
        ]);


        // 2. Computer Science
        JobDetail::create([
            'job_title' => 'Java Programmer',
            'industry_id' => 11,
            'company' => 'Globe Telecom',
            'location' => 'Makati City',
            'job_type' => 'full-time',
            'salary_range' => '35,000 - 45,000',
            'job_description' => 'Responsible for developing and maintaining backend services using Java and Spring Boot frameworks. Must have experience in REST APIs, data structures, and system optimization. Ideal candidates demonstrate analytical thinking, adaptability, and collaboration with cross-functional teams.',
        ]);


        // 3. Business Administration - Marketing
        JobDetail::create([
            'job_title' => 'Marketing Coordinator',
            'industry_id' => 5,
            'company' => 'SM Retail Inc.',
            'location' => 'Quezon City',
            'job_type' => 'full-time',
            'salary_range' => '25,000 - 35,000',
            'job_description' => 'Assist in planning and executing marketing campaigns, social media promotions, and brand awareness projects. Familiarity with digital marketing tools, content creation, and customer engagement strategies is required. Must have strong communication, creativity, and organization skills.',
        ]);


        // 4. Accountancy
        JobDetail::create([
            'job_title' => 'Junior Accountant',
            'industry_id' => 4,
            'company' => 'PwC Philippines',
            'location' => 'Makati City',
            'job_type' => 'full-time',
            'salary_range' => '28,000 - 40,000',
            'job_description' => 'Responsible for preparing financial reports, reconciling accounts, and assisting in audits. Proficiency in Microsoft Excel, accounting systems, and analytical thinking is required. Must demonstrate integrity, attention to detail, and the ability to work under pressure while meeting deadlines.',
        ]);


        // 5. Entrepreneurship
        JobDetail::create([
            'job_title' => 'Business Development Associate',
            'industry_id' => 5,
            'company' => 'Ayala Land Inc.',
            'location' => 'Taguig City',
            'job_type' => 'full-time',
            'salary_range' => '30,000 - 42,000',
            'job_description' => 'Identify new business opportunities, analyze market trends, and assist in product development. Strong skills in communication, negotiation, and project management are essential. Ideal candidates are entrepreneurial, self-motivated, and capable of working with minimal supervision.',
        ]);


        // 6. Hospitality Management
        JobDetail::create([
            'job_title' => 'Guest Relations Officer',
            'industry_id' => 7,
            'company' => 'Shangri-La The Fort Manila',
            'location' => 'Taguig City',
            'job_type' => 'full-time',
            'salary_range' => '22,000 - 30,000',
            'job_description' => 'Provide excellent guest service by handling check-ins, reservations, and guest inquiries. Ensure guest satisfaction through problem-solving, empathy, and communication. Knowledge in hotel management systems, multitasking, and professionalism is required.',
        ]);


        // 7. Education (BSED English)
        JobDetail::create([
            'job_title' => 'High School English Teacher',
            'industry_id' => 8,
            'company' => 'Pasig City Science High School',
            'location' => 'Pasig City',
            'job_type' => 'full-time',
            'salary_range' => '27,000 - 35,000',
            'job_description' => 'Teach English grammar, literature, and writing to secondary students. Prepare lesson plans and assess student performance. Must demonstrate communication, patience, classroom management, and creativity in developing engaging learning materials.',
        ]);


        // 8. Psychology
        JobDetail::create([
            'job_title' => 'Human Resource Assistant',
            'industry_id' => 6,
            'company' => 'Nestlé Philippines',
            'location' => 'Makati City',
            'job_type' => 'full-time',
            'salary_range' => '30,000 - 38,000',
            'job_description' => 'Assist in recruitment, training, and employee engagement programs. Ideal candidates have background in industrial psychology, data analysis, and employee relations. Must have strong interpersonal skills, confidentiality, and empathy in handling sensitive information.',
        ]);


        // 9. Electronics Engineering
        JobDetail::create([
            'job_title' => 'Electronics Design Engineer',
            'industry_id' => 9,
            'company' => 'Samsung Electronics Philippines',
            'location' => 'Laguna Technopark',
            'job_type' => 'full-time',
            'salary_range' => '40,000 - 55,000',
            'job_description' => 'Design, test, and improve electronic circuits and embedded systems. Proficiency in MATLAB, C/C++, and PCB design software is required. Must have problem-solving, analytical, and collaboration skills with a focus on innovation and product quality.',
        ]);


        // 10. Nursing
        JobDetail::create([
            'job_title' => 'Registered Nurse',
            'industry_id' => 10,
            'company' => 'St. Luke’s Medical Center',
            'location' => 'Quezon City',
            'job_type' => 'full-time',
            'salary_range' => '35,000 - 50,000',
            'job_description' => 'Provide high-quality nursing care to patients in medical and surgical units. Monitor vital signs, administer medication, and assist doctors during procedures. Requires compassion, critical thinking, teamwork, and adherence to hospital safety protocols.',
        ]);
    }
}
