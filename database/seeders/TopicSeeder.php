<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = [
            [
                'title' => 'Sirah Nabawiyah',
            ],
            [
                'title' => 'Fiqih'
            ]
            ];
            foreach ($topic as $key => $value) {
                Topic::insert($value);
            }
    }
}
