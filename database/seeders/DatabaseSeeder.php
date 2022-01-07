<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Quiz;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuizUser;
use App\Models\RoomUser;
use App\Models\Leaderboard;
use Illuminate\Support\Str;
use App\Models\RoomQuestion;
use Illuminate\Database\Seeder;
use App\Models\UserQuestionRoom;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $topics = Topic::getRawData(); 
        $quizzes = Quiz::getRawData();

        // seed topic, quizzes, questions
        foreach($topics as $index => $topic){
            // seed topic
            $newTopic = Topic::factory()->create([
                'title' => $topic,
                'slug' => Str::slug($topic, "-"),
            ]);
            // seed quiz based on topic 
            foreach($quizzes[$index] as $index2 => $quiz){
                // prepare quiz data
                $quizData = [
                    'topic_id' => $newTopic->id,
                    'title' => $quiz,
                    'slug' => Str::slug($quiz),
                    'counter' => $index2,
                    'image' => 'card.png'
                ];
                // change quiz image 
                if($quiz == "Nabi Ibrahim AS"){
                   $quizData['image'] = "card.png";
                   $quizData['counter'] = 50;
                }elseif($quiz == "Nabi Muhammad SAW"){
                    $quizData['image'] = "card.png";
                    $quizData['counter'] = 50;
                }
                $newQuiz = Quiz::factory()->create($quizData); 

                // seed question based on quiz 
                if($newQuiz->id === 25){
                    // seed question nabi ibrahim
                    $dataQuestion = Question::getQuestionsQuizNabiIbrahim();
                    foreach($dataQuestion as $question){
                        Question::factory()->create($question);
                    }
                }elseif($newQuiz->id === 26){
                    // seed question nabi ibrahim
                    $dataQuestion = Question::getQuestionQuizNabiMuhammad();
                    foreach($dataQuestion as $question){
                        Question::factory()->create($question);
                    }
                }else {
                    // seed other quiz 
                    Question::factory(10)->create([
                        'quiz_id' => $newQuiz->id
                    ]);
                }
            }
        }

        // seed admin
        $dataAdmin = [
            "name" => "Admin KUISLAM",
            "email" => "islamic.quizgenerator@gmail.com",
            "username" => "admin-kuislam",
            "password" => Hash::make("IslamQuiz2021"),
            "role" => "admin",
        ];
        User::factory()->create($dataAdmin);
        
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
