<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EventAttendeesTableSeeder extends Seeder
{
    public function run(): void
    {
        $attendees = [];

        // Alumni IDs 2–13
        $alumniIds = range(2, 13);

        // Event 1 (Homecoming): Most alumni attending
        foreach ([2, 3, 4, 5, 6, 7, 8, 9] as $userId) {
            $attendees[] = [
                'user_id' => $userId,
                'event_id' => 1,
                'rsvp_status' => 'going',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Event 2 (Workshop): Mixed RSVP
        foreach ([3, 4, 5, 10, 11] as $userId) {
            $attendees[] = [
                'user_id' => $userId,
                'event_id' => 2,
                'rsvp_status' => collect(['going', 'maybe'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Event 3 (Job Fair): Done event
        foreach ([2, 6, 7, 8, 12] as $userId) {
            $attendees[] = [
                'user_id' => $userId,
                'event_id' => 3,
                'rsvp_status' => collect(['going', 'not going', 'maybe'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Event 4 (Webinar): Smaller group
        foreach ([9, 10, 13] as $userId) {
            $attendees[] = [
                'user_id' => $userId,
                'event_id' => 4,
                'rsvp_status' => collect(['going', 'maybe'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('event_attendees')->insert($attendees);
    }
}
