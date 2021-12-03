<?php

namespace App\Models;

use App\Models\Topic;
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
