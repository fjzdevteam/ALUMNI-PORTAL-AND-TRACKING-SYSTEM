<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EventDetailsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('event_details')->insert([
            [
                'event_title' => 'PLP Alumni Homecoming 2025',
                'event_type_id' => 1,
                'event_date' => Carbon::parse('2025-12-15'),
                'event_time' => '18:00:00',
                'location' => 'PLP Main Campus Gymnasium',
                'event_description' => 'An evening of celebration and reconnection for all PLP graduates across different batches.',
                'status' => 'upcoming',
                'rsvp_deadline' => Carbon::parse('2025-12-10'),
                'link' => 'https://plp.edu.ph/alumni-homecoming-2025',
                'event_date_posted' => Carbon::parse('2025-10-20'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_title' => 'Career Growth Workshop: Building a Future in Tech',
                'event_type_id' => 7,
                'event_date' => Carbon::parse('2025-11-10'),
                'event_time' => '09:00:00',
                'location' => 'PLP ICT Auditorium',
                'event_description' => 'A skills-focused workshop designed to equip alumni with in-demand technical knowledge and job readiness.',
                'status' => 'upcoming',
                'rsvp_deadline' => Carbon::parse('2025-11-05'),
                'link' => 'https://plp.edu.ph/tech-career-workshop',
                'event_date_posted' => Carbon::parse('2025-10-22'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_title' => 'Job Fair 2025: Connecting Talent with Opportunity',
                'event_type_id' => 2,
                'event_date' => Carbon::parse('2025-09-15'),
                'event_time' => '08:00:00',
                'location' => 'PLP Quadrangle',
                'event_description' => 'A job fair that connects alumni and graduating students with partner companies and organizations.',
                'status' => 'done',
                'rsvp_deadline' => Carbon::parse('2025-09-10'),
                'link' => 'https://plp.edu.ph/job-fair-2025',
                'event_date_posted' => Carbon::parse('2025-08-25'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_title' => 'Webinar: Adapting to the Post-Pandemic Workforce',
                'event_type_id' => 6,
                'event_date' => Carbon::parse('2025-08-01'),
                'event_time' => '13:00:00',
                'location' => 'Zoom',
                'event_description' => 'A virtual talk series for alumni to discuss the evolving trends and demands of the modern workplace.',
                'status' => 'done',
                'rsvp_deadline' => Carbon::parse('2025-07-28'),
                'link' => 'https://plp.edu.ph/alumni-webinar-2025',
                'event_date_posted' => Carbon::parse('2025-07-10'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
