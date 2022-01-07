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

    public static function getQuestionQuizNabiMuhammad()
    {
        $questions = [
            [
                'quiz_id' => 25,
                'question' => "Ayah Nabi Muhammad bernama ......",
                'option_1' => 'Abdullah',
                'option_2' => 'Ibrahim',
                'option_3' => 'Abu thalib',
                'option_4' => 'Abdul Muthalib',
                'answer' => 'option_1',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Penduduk asli Madinah yang menyambut kedatangan kaum Muslimin ketika Hijrah disebut kaum ....",
                'option_1' => 'Anshor',
                'option_2' => 'Muhajirin',
                'option_3' => 'Muslimin',
                'option_4' => 'Quraisy',
                'answer' => 'option_1',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Muhammad dilahirkan pada tanggal ....",
                'option_1' => '10 Dzulhijah',
                'option_2' => '1 Muharom',
                'option_3' => '12 Rabiul Awal',
                'option_4' => '12 Syawwal',
                'answer' => 'option_3',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Sebelum Nabi Muhammad SAW. datang ke Madinah nama kota Madinah adalah….",
                'option_1' => 'Makkah',
                'option_2' => 'Yaman',
                'option_3' => 'Yatsrib',
                'option_4' => 'Habasyah',
                'answer' => 'option_3',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Rasulullah SAW. menerima wahyu pertama di….",
                'option_1' => 'Gua Hira',
                'option_2' => 'Kabah',
                'option_3' => 'Masjidil Haram',
                'option_4' => 'Padang Arafah',
                'answer' => 'option_1',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Muhammad SAW. berdakwah di Makkah selama….",
                'option_1' => '10 tahun',
                'option_2' => '13 tahun',
                'option_3' => '23 tahun',
                'option_4' => '30 tahun',
                'answer' => 'option_2',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Berikut ini adalah tahapan- tahapan dakwah Rasulullah saw pada periode Makkah, kecuali ….",
                'option_1' => 'Dakwah secara diam- diam',
                'option_2' => 'Dakwah kepada berbagai suku disekitar Makkah',
                'option_3' => 'Dakwah dikalangan keluarga',
                'option_4' => 'Dakwah secara terang- terangan',
                'answer' => 'option_4',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Paman Nabi Muhammad yang merawat dan mengajaknya berdagang adalah ....",
                'option_1' => 'Abu Jahal',
                'option_2' => 'Abu Thalib',
                'option_3' => 'Abu Lahab',
                'option_4' => 'Abbas',
                'answer' => 'option_2',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Pada waktu kecil Nabi Muhammd mempunyai kegiatan ....",
                'option_1' => 'Mengembala kambing',
                'option_2' => 'Berdagang kambing',
                'option_3' => 'Mengembala unta',
                'option_4' => 'Menanam pohon kurma',
                'answer' => 'option_1',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Tentara bergajah yang ingin menghancurkan Kabah dipimpin oleh raja ....",
                'option_1' => 'Abu Lahab',
                'option_2' => 'Abu Sufyan',
                'option_3' => 'Safwan',
                'option_4' => 'Abrahah',
                'answer' => 'option_4',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Salah satu sifat Nabi Muhammad adalah Al Amiin yang artinya ...",
                'option_1' => 'Orang yang sombong',
                'option_2' => 'Orang yang dapat dipercaya',
                'option_3' => 'Orang yang pintar',
                'option_4' => 'Orang yang suka menolong',
                'answer' => 'option_2',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Kaum Muslimin yang ikut hijrah ke Madinah disebut kaum ...",
                'option_1' => 'Anshor',
                'option_2' => 'Muhajirin',
                'option_3' => 'Quraisy',
                'option_4' => 'Kafir',
                'answer' => 'option_2',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Siapa nama sahabat Nabi Muhammad yang menemani ketika Hijrah ke Madinah ....",
                'option_1' => 'Abu Bakar As shidiq',
                'option_2' => 'Umar Bin Khattab',
                'option_3' => 'Usman Bin Affan',
                'option_4' => 'Ali Bin Abi Thalib',
                'answer' => 'option_1',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Ibu dari Nabi Muhammad bernama ....",
                'option_1' => 'Siti Khadijah',
                'option_2' => 'Siti Aminah',
                'option_3' => 'Siti Hajar',
                'option_4' => 'Siti Aisyah',
                'answer' => 'option_2',
                'time' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Ayah Nabi Muhammad meninggal saat ....",
                'option_1' => 'Nabi Muhammad berusia 5 tahun',
                'option_2' => 'Nabi Muhammad masih dalam kandungan',
                'option_3' => 'Nabi Muhammad berusian 2 tahun',
                'option_4' => 'Nabi Muhammad sudah jadi Nabi',
                'answer' => 'option_2',
                'time' => 30
            ]
        ];
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
