<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\RoomQuestion;
use App\Models\UserQuestionRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function getQuestionsQuizNabiIbrahim()
    {
        $questions = [
            [
                'quiz_id' => 25,
                'question' => "Dimana nabi ibrahim di lahirkan?",
                'option_1' => 'Ur Kasdim',
                'option_2' => 'Madinah',
                'option_3' => 'Puerto Rico',
                'option_4' => 'Jakarta',
                'answer' => 'option_1',
                'timer' => 50
            ]
        ];
        return $questions;
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function roomquestions()
    {
        return $this->hasMany(RoomQuestion::class);
    }

    public function userquestionrooms()
    {
        return $this->hasMany(UserQuestionRoom::class);
    }

    public static function getTotalQuestions($quizId){
        return Question::where('quiz_id', $quizId)->get()->count();
    }

    public static function getRandomQuestion($quizId){
        $numbers =  range(1, Question::getTotalQuestions($quizId));
        shuffle($numbers);
        return array_slice($numbers, 0, 10);
    }

    public static function getAllQuestion(){
        return Question::all()->sortBy('title');
    }

    public static function getOneQuestion($id){
        return Question::where('id', $id)->first();
    }

    public static function updateQuestion($id, $data){
        return Question::where('id', $id)->update($data);
    }

    public static function deleteQuestion($id){
        return Question::where('id', $id)->delete();
    }
}
