<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuizUser;
use App\Models\RoomUser;
use App\Models\Leaderboard;
use App\Models\RoomQuestion;
use Illuminate\Database\Seeder;
use App\Models\UserQuestionRoom;
use Database\Seeders\QuizSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TopicSeeder;
use Database\Seeders\QuestionSeeder;
use Database\Seeders\RoomUserSeeder;
use Database\Seeders\LeaderboardSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Topic::factory(4)
            ->has(Quiz::factory()->count(10))
            ->create();

        Question::factory()->count(20)->create();
        Room::factory(3)->create();
        RoomQuestion::factory(3)->create();
        
        User::factory(4)
            ->has(Leaderboard::factory()->count(1))
            ->has(QuizUser::factory()->count(4))
            ->has(RoomUser::factory()->count(4))
            ->has(UserQuestionRoom::factory()->count(4))
            ->create();
    }
}
