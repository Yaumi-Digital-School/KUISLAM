<?php

namespace Database\Seeders;

use App\Models\RoomUser;
use Illuminate\Database\Seeder;

class RoomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomUser = [
            [
                'user_id' => 1,
                'room_id' => 1,
                'rank' => 1,
                'points' => 10000,
                'is_host' => true,
                'is_active' => false
            ],
            [
                'user_id' => 2,
                'room_id' => 1,
                'rank' => 2,
                'points' => 9000,
                'is_host' => false,
                'is_active' => false
            ],
            [
                'user_id' => 3,
                'room_id' => 1,
                'rank' => 3,
                'points' => 8000,
                'is_host' => false,
                'is_active' => false
            ],
            [
                'user_id' => 4,
                'room_id' => 1,
                'rank' => 4,
                'points' => 7000,
                'is_host' => false,
                'is_active' => false
            ],
            [
                'user_id' => 1,
                'room_id' => 2,
                'rank' => 1,
                'points' => 10000,
                'is_host' => true,
                'is_active' => false
            ],
            [
                'user_id' => 2,
                'room_id' => 2,
                'rank' => 2,
                'points' => 9000,
                'is_host' => false,
                'is_active' => false
            ],
            [
                'user_id' => 1,
                'room_id' => 3,
                'rank' => 1,
                'points' => 8000,
                'is_host' => true,
                'is_active' => false
            ],
            [
                'user_id' => 2,
                'room_id' => 3,
                'rank' => 2,
                'points' => 7000,
                'is_host' => false,
                'is_active' => false
            ]
            ];
            foreach ($roomUser as $key => $value) {
                RoomUser::insert($value);
            }
    }
}
