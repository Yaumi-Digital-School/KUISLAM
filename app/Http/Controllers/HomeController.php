<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function index(){
        $quizzes = Quiz::with('topic')->latest()->get()->groupBy('topic.title'); 
        if(Auth::check()){
            // ganti data nya ya kalo dia udah login
            return view('welcome', ['quizzes' => $quizzes]);
        }
        return view('welcome', ['quizzes' => $quizzes]);
    }

    public function discover(){
        $search = Request()->query('search');

        if($search){
            $quizzes = Quiz::where('title', 'LIKE', "%{$search}%")->with('topic')->latest()->get()->groupBy('topic.title');
        }else{
            $quizzes = Quiz::with('topic')->latest()->get()->groupBy('topic.title');
        }

        return view('discover', compact('quizzes'));
    }
}
