<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $this->call([
            UserSeeder::class,
            LeaderboardSeeder::class,
            TopicSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            RoomSeeder::class,
            RoomUserSeeder::class,
        ]);
    }
}
