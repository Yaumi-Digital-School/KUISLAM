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
                'option_4' => 'Mekkah',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim mengingatkan ayahnya untuk...",
                'option_1' => 'Membunuh raja yang jahat',
                'option_2' => 'Membela yang lemah',
                'option_3' => 'Berhenti menyembah berhala',
                'option_4' => 'Semangat membuat berhala',
                'answer' => 'option_3',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim adalah seorang nabi yang sangat...",
                'option_1' => 'Taat',
                'option_2' => 'Tampan',
                'option_3' => 'Penakut',
                'option_4' => 'Lucu',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim adalah Nabi yang berani, ia berani...",
                'option_1' => 'Membela para penjahat',
                'option_2' => 'Menangkap pencuri berhala',
                'option_3' => 'Menangkap para penjahat',
                'option_4' => 'Menghancurkan banyak berhala',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Ayah Nabi Ibrahim bernama...",
                'option_1' => 'Azzar',
                'option_2' => 'Abdullah',
                'option_3' => 'Ismail',
                'option_4' => 'Abu Lahab',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim dilahirkan di lingkungan yang warganya banyak menyembah...",
                'option_1' => 'Matahari',
                'option_2' => 'Berhala',
                'option_3' => 'Setan',
                'option_4' => 'Pohon',
                'answer' => 'option_2',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim tidak mau menyembah berhala, alasannya yaitu percaya bahwa Tuhan jumlahnya hanya ada...",
                'option_1' => 'Banyak',
                'option_2' => '2',
                'option_3' => '3',
                'option_4' => '1',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Apa pekerjaan ayah Nabi Ibrahim?",
                'option_1' => 'Juru masak',
                'option_2' => 'Ulama',
                'option_3' => 'Menteri raja',
                'option_4' => 'Pembuat berhala',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi ibrahim juga dikenal sebagai ... para Nabi",
                'option_1' => 'Anak',
                'option_2' => 'Kakek',
                'option_3' => 'Paman',
                'option_4' => 'Bapak',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Istri Nabi Ibrahim bernama Hajar dan ...",
                'option_1' => 'Khadijah',
                'option_2' => 'Aminah',
                'option_3' => 'Sarah',
                'option_4' => 'Maryam',
                'answer' => 'option_3',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => " Peristiwa ketika Nabi Ibrahim akan menyembelih anaknya dan diganti domba diperingati sebagai hari...",
                'option_1' => 'Qurban',
                'option_2' => 'Sembelih',
                'option_3' => 'libur',
                'option_4' => 'Fitri',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim termasuk rasul ulul azmi karena ia memiliki...",
                'option_1' => 'Kekebalan',
                'option_2' => 'Mukjizat',
                'option_3' => 'Kitab',
                'option_4' => 'Kesabaran yang luar biasa',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Ketika api akan membakar Nabi Ibrahim, Allah memerintahkan api untuk menjadi...",
                'option_1' => 'Semakin besar',
                'option_2' => 'Kecil',
                'option_3' => 'Asap',
                'option_4' => 'Dingin',
                'answer' => 'option_4',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Perilaku Nabi Ibrahim tidak menghancurkan semua berhala dan mengalungkan kapaknya di salah satunya bertujuan untuk...",
                'option_1' => 'Agar ada yang masih disembah',
                'option_2' => 'Agar banyak orang yang mengira ada berhala yang paling kuat',
                'option_3' => 'Agar penduduk berpikir bahwa berhala itu benda mati',
                'option_4' => 'Agar berhala itu dianggap hebat',
                'answer' => 'option_3',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim pernah diperintah oleh Allah Ta’ala untuk...",
                'option_1' => 'Menyembelih anaknya',
                'option_2' => 'Menjual anaknya',
                'option_3' => 'Menambah anaknya',
                'option_4' => 'Mengubur anaknya',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Karena terus menentang Raja maka Nabi Ibrahim pernah dihukum dengan cara...",
                'option_1' => 'Dihanyutkan',
                'option_2' => 'Dibakar',
                'option_3' => 'Disembelih',
                'option_4' => 'Dibuang kelaut',
                'answer' => 'option_2',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nabi Ibrahim menyadari bahwa kaumnya yang menyembah berhala adalah perbuatan yang...",
                'option_1' => 'Mulia',
                'option_2' => 'Sesat',
                'option_3' => 'Terpuji',
                'option_4' => 'Mendatangkan keuntungan',
                'answer' => 'option_2',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Perilaku Nabi Ibrahim yang perlu kita teladani dalam hal akidah adalah...",
                'option_1' => 'Belajar dengan rajin',
                'option_2' => 'Mentaati perintah ayahnya',
                'option_3' => 'Tidak pernah menyekutukan Allah',
                'option_4' => 'Menyayangi anaknya',
                'answer' => 'option_3',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Saat nabi Ibrahim menghanucrkan berhala yang disembanh di lingkungannya, ia menyisakan berhala yang...",
                'option_1' => 'Paling besar',
                'option_2' => 'Paling kecil',
                'option_3' => 'Paling buruk',
                'option_4' => 'Paling bagus',
                'answer' => 'option_1',
                'timer' => 30
            ],
            [
                'quiz_id' => 25,
                'question' => "Nama Raja yang menghukum Nabi Ibrahim adalah...",
                'option_1' => 'Raja Firaun',
                'option_2' => 'Raja Richard',
                'option_3' => 'Raja Namrud',
                'option_4' => 'Raja Cesar',
                'answer' => 'option_3',
                'timer' => 30
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
