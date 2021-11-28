<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = [
            [
                'quiz_id' => '1',
            ],
            [
                'quiz_id' => '1',
            ]
            ];
            foreach ($question as $key => $value) {
                Question::insert($value);
            }
    }
}
