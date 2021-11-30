<?php

namespace Database\Seeders;

use App\Models\Leaderboard;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaderboard = [
            [
                'user_id' => 1,
                'point' => 10000
            ],
            [
                'user_id' => 2,
                'point' => 25000
            ]
            ];
            foreach ($leaderboard as $key => $value) {
                Leaderboard::insert($value);
            }
    }
}
