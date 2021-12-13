<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function index(){
        return view('welcome');
    }

    public function discover(){
        $quizzes = Quiz::with('topic')->latest()->get()->groupBy('topic.title');

        return view('discover', compact('quizzes'));
    }
}
