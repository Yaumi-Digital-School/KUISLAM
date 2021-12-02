<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = [
            [
                'quiz_id' => 1,
                'code' => 156462,
            ],
            [
                'quiz_id' => 2,
                'code' => 141512,
            ],
            [
                'quiz_id' => 3,
                'code' => 412421,
            ]
            ];
            foreach ($room as $key => $value) {
                Room::insert($value);
            }
    }
}
