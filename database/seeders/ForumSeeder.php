<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use Carbon\Carbon;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $forums = [
            [
                'user_id' => 2,
                'category_id' => 1,
                'topic_title' => 'Welcome to the PLP Alumni Forum!',
                'content' => 'Let’s use this space to share updates and connect with fellow PLP graduates.',
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now->copy()->subDays(10),
            ],
            [
                'user_id' => 3,
                'category_id' => 2,
                'topic_title' => 'Career Growth Tips for Fresh Graduates',
                'content' => 'What are some effective strategies for landing your first job after graduation?',
                'created_at' => $now->copy()->subDays(9),
                'updated_at' => $now->copy()->subDays(9),
            ],
            [
                'user_id' => 4,
                'category_id' => 3,
                'topic_title' => 'Upcoming Alumni Homecoming 2025',
                'content' => 'Who’s excited for the annual alumni homecoming? Let’s plan meetups and activities!',
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(8),
            ],
            [
                'user_id' => 5,
                'category_id' => 4,
                'topic_title' => 'Favorite Memories at PLP',
                'content' => 'Share your most memorable moments at Pamantasan ng Lungsod ng Pasig!',
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(7),
            ],
            [
                'user_id' => 6,
                'category_id' => 5,
                'topic_title' => 'Suggestions for the Alumni Portal',
                'content' => 'How can we improve the user experience in the alumni portal?',
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ],
            [
                'user_id' => 7,
                'category_id' => 2,
                'topic_title' => 'Internship Opportunities for IT Graduates',
                'content' => 'If anyone knows of companies hiring interns, please share here.',
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'user_id' => 8,
                'category_id' => 3,
                'topic_title' => 'PLP Sportsfest Recap',
                'content' => 'The Sportsfest was amazing! Here’s a quick recap of the winners and highlights.',
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'user_id' => 9,
                'category_id' => 4,
                'topic_title' => 'PLP Alumni Networking on LinkedIn',
                'content' => 'Have you joined the official PLP Alumni group on LinkedIn yet?',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'user_id' => 10,
                'category_id' => 5,
                'topic_title' => 'Portal Loading Issues',
                'content' => 'Has anyone experienced slow loading times on the alumni portal?',
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'user_id' => 11,
                'category_id' => 1,
                'topic_title' => 'New Feature: Alumni Career Tracker',
                'content' => 'Admins just added a new career tracking tool — check it out and share feedback!',
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ],
            [
                'user_id' => 12,
                'category_id' => 2,
                'topic_title' => 'Master’s Scholarship Opportunities',
                'content' => 'Are there any available scholarships for alumni pursuing graduate studies?',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 13,
                'category_id' => 4,
                'topic_title' => 'Remote Work Setup Tips',
                'content' => 'How do you stay productive while working from home? Share your best practices.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Forum::insert($forums);
    }
}
