<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public static function getAllTopic(){
        return Topic::all()->sortBy('title');
    }

    public static function getOneTopic($id){
        return Topic::where('id', $id)->first();
    }

    public static function updateTopic($id, $data){
        return Topic::where('id', $id)->update($data);
    }

    public static function deleteTopic($id){
        return Topic::where('id', $id)->delete();
    }
}
