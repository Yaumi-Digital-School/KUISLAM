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
    protected $guarded = ['id'];

    public static function getRawData()
    {
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
                "Nabi Muhammad SAW",
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
        return $quizzes;
    }

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

    public static function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function getQuizId($quizId){
        return Quiz::where('id', $quizId)->first();
    }

    public static function getQuizSlug($slug){
        return Quiz::where('slug', $slug)->first();
    }
    
    public static function getAllQuiz(){
        return Quiz::all()->sortBy('title');
    }

    public static function getQuizGroupByTitle(){
        return Quiz::with('topic')->latest()->get()->groupBy('topic.title');
    }

    public static function getPopularQuiz($total){
        return Quiz::get()->SortByDesc('counter')->take($total);
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
