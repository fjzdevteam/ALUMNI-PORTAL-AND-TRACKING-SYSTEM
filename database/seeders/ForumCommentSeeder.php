<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumComment;
use Carbon\Carbon;

class ForumCommentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $comments = [
            ['forum_id' => 1, 'user_id' => 3, 'comment' => 'Happy to be part of this forum!', 'created_at' => $now->subDays(9)],
            ['forum_id' => 1, 'user_id' => 5, 'comment' => 'Great initiative by the alumni office!', 'created_at' => $now->subDays(8)],
            ['forum_id' => 2, 'user_id' => 4, 'comment' => 'Networking and attending webinars helped me a lot.', 'created_at' => $now->subDays(8)],
            ['forum_id' => 3, 'user_id' => 6, 'comment' => 'Count me in for the homecoming event!', 'created_at' => $now->subDays(7)],
            ['forum_id' => 4, 'user_id' => 7, 'comment' => 'I miss the library sessions with friends!', 'created_at' => $now->subDays(6)],
            ['forum_id' => 5, 'user_id' => 8, 'comment' => 'Dark mode would be a cool addition!', 'created_at' => $now->subDays(5)],
            ['forum_id' => 6, 'user_id' => 9, 'comment' => 'Check out ABC Tech — they’re accepting IT interns.', 'created_at' => $now->subDays(5)],
            ['forum_id' => 7, 'user_id' => 10, 'comment' => 'It was a fun event, glad to see everyone again!', 'created_at' => $now->subDays(4)],
            ['forum_id' => 8, 'user_id' => 11, 'comment' => 'Yes! It’s a great way to connect professionally.', 'created_at' => $now->subDays(3)],
            ['forum_id' => 9, 'user_id' => 12, 'comment' => 'The portal loads fine for me now after the update.', 'created_at' => $now->subDays(2)],
            ['forum_id' => 10, 'user_id' => 13, 'comment' => 'Tried it, and it’s super helpful!', 'created_at' => $now->subDay()],
            ['forum_id' => 11, 'user_id' => 2, 'comment' => 'Following! I’m also looking for scholarship info.', 'created_at' => $now],
            ['forum_id' => 12, 'user_id' => 3, 'comment' => 'Invest in a good chair and have regular breaks!', 'created_at' => $now],
        ];

        ForumComment::insert($comments);
    }
}
