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
                'code' => 1562,
            ],
            [
                'quiz_id' => 2,
                'code' => 1412,
            ],
            [
                'quiz_id' => 3,
                'code' => 4121,
            ]
            ];
            foreach ($room as $key => $value) {
                Room::insert($value);
            }
    }
}
