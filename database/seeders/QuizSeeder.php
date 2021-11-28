<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quiz = [
            [
                'topic_id' => '1',
                'title' => 'Sirah Nabi Muhammad',
                'image' => 'Sirah-Nabi-Muhammad.jpg',
            ],
            [
                'topic_id' => '1',
                'title' => 'Sirah Nabi Adam',
                'image' => 'Sirah-Nabi-Adam.jpg',
            ],
            [
                'topic_id' => '2',
                'title' => 'Fiqih Shalat',
                'image' => 'Fiqih-Shalat.jpg',
            ]
            ];
            foreach ($quiz as $key => $value) {
                Quiz::insert($value);
            }
    }
}
