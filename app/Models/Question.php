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

    protected static function getTotalQuestions($quizId){
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
