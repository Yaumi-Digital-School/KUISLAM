<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuizUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizusers()
    {
        return $this->hasMany(QuizUser::class);
    }

    public static function getQuizId($quizId){
        return Quiz::where('id', $quizId)->first();
    }
    
    public static function getAllQuiz(){
        return Quiz::all()->sortBy('title');
    }
    
    public static function getOneQuiz($id){
        return Quiz::findOrfail($id);
    }

    public static function updateQuiz($id, $data){
        return Quiz::findOrfail($id)->update($data);
    }

    public static function deleteQuiz($id){
        return Quiz::findOrfail($id)->delete();
    }
}
