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
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_1',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_2',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_3',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_4',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_1',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_2',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_3',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_4',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_1',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_2',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_3',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_4',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_1',
                'timer' => 30,
            ],
            [
                'quiz_id' => '1',
                'question' => 'abcd',
                'option_1' => 'A',
                'option_2' => 'B',
                'option_3' => 'C',
                'option_4' => 'D',
                'answer' => 'option_2',
                'timer' => 30,
            ]
            ];
            foreach ($question as $key => $value) {
                Question::insert($value);
            }
    }
}
