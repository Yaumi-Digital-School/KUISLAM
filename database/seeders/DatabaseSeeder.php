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
use App\Models\UserQuestionRoom;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $topics = ["Al-quran", "Fiqih", "Kisah Nabi", "Tajwid"];
        $quizzes = [
            [
                "Surat Al-Fatihah",
                "Surat Al-Baqarah",
                "Surat Al-Imran",
                "Surat An-Nisaa",
                "Surat Al-Ma'ida",
                "Surat Al-An'am",
                "Surat Al-Anfal",
                "Surat At-Taubah",
                "Surat Yunus",
            ],
            [
                "Tharah",
                "Shalat",
                "Itikaf",
                "Puasa",
                "Zakat",
                "Haji",
                "Sedekah dan Infaq",
                "Qurban",
                "Aqiqah",
            ],
            [
                "Nabi Adam AS",
                "Nabi Idris AS",
                "Nabi Nuh AS",
                "Nabi Hud AS",
                "Nabi Sholeh AS",
                "Nabi Luth AS",
                "Nabi Ibrahim AS",
                "Nabi Ismail AS",
                "Nabi Ishaq AS",
                "Nabi Yaqub AS",
            ],
            [
                "Idhgam",
                "Idzhar",
                "Iqlab",
                "Ikhfa",
            ],
        ];
        // seed topic, quizzes, questions
        foreach($topics as $index => $topic){
            // seed topic
            $newTopic = Topic::factory()->create([
                'title' => $topic,
                'slug' => Str::slug($topic, "-"),
            ]);
            // seed quiz based on topic 
            foreach($quizzes[$index] as $index => $quiz){
                $newQuiz = Quiz::factory()->create([
                    'topic_id' => $newTopic->id,
                    'title' => $quiz,
                    'slug' => Str::slug($quiz),
                    'image' => 'card.jpg',
                ]);
                // seed question based on  quiz 
                Question::factory(10)->create([
                    'quiz_id' => $newQuiz->id
                ]);
            }
        }

        // // // seed users
        User::factory(4)->create();
        
        // seed room_users 
        // make 2 new room with each room contains 2 users
        Room::factory(2)->create([
            'quiz_id' => Quiz::inRandomOrder()->first()->id,
            'status' => 'done'
        ])->each(function($room){
            User::inRandomOrder()->paginate(2)->each(function($user) use($room){
                RoomUser::factory()->create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'status' => 'done'
                ]);
            });
        });

        // seed room questions 
        Room::all()->each(function($room){
            Question::inRandomOrder()->paginate(10)->each(function($question, $index) use($room){
                RoomQuestion::factory()->create([
                    'question_id' => $question->id,
                    'room_id' => $room->id,
                    'order' => $index + 1,
                ]);
            });
        });

        // seed user question room 
        RoomQuestion::all()->each(function($room_question){
            $room_users = $room_question->room->roomusers;
            foreach($room_users as $user){
                $answerOptions = ['option_1', 'option_2', 'option_3', 'option_4'];
                $array_index = array_rand($answerOptions);
                $answer = $answerOptions[$array_index];
                $is_correct = $room_question->question->answer == $answer;
                UserQuestionRoom::factory()->create([
                    'user_id' => $user->id,
                    'room_id' => $room_question->room_id,
                    'question_id' => $room_question->question_id,
                    'order' => $room_question->order,
                    'answer_option' => $answer,
                    'is_correct' => $is_correct
                ]);
            }
        });
    }
}
