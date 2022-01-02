<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\RoomUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserQuestionRoom;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function adminDashboard(){
        $users = User::count();
        $topics = Topic::count();
        $questions = Question::count();
        return view('admin.dashboard', compact('users', 'topics', 'questions'));
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function index(){
        $quizzes = Quiz::getPopularQuiz();
        
        if(Auth::check()){
            $roomUser = RoomUser::getAllDoneQuiz();

            if($roomUser->isNotEmpty()){
                $hasActivity = true;
                return view('welcome', compact('quizzes', 'roomUser', 'hasActivity'));  
            }

            $hasActivity = false;
            return view('welcome', compact('quizzes', 'roomUser', 'hasActivity'));           
        }
        $hasActivity = false;
        return view('welcome', compact('quizzes', 'hasActivity'));
    }

    public function redirect($message){
        // dd($message);
        if($message == "host_exit_room"){
            return redirect()->route('index')->with('message', "Host telah membatalkan permainan!");
        }
    }

    public function discover(){
        $search = Request()->query('search');
        $selectedTopic = Request()->query('topic');

        $topic = Topic::where('slug', $selectedTopic)->first();
        $topics = Topic::limit(4)->get();
        
        if($search){
            $quizzes = Quiz::where('title', 'LIKE', "%{$search}%")->orWhere('slug', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%")->with('topic')->latest()->get()->groupBy('topic.title');
        }elseif($selectedTopic){
            $quizzes = Quiz::where('topic_id', 'LIKE', "%{$topic->id}%")->with('topic')->latest()->get()->groupBy('topic.title');
        }else{
            $quizzes = Quiz::getQuizGroupByTitle();
        }

        return view('discover', ['quizzes' => $quizzes, 'topics' => $topics, 'selectedTopic' => $topic]);
    }

    public function activity(){
        $roomUser = RoomUser::getAllDoneQuiz();
             
        return view('activity', compact('roomUser'));   
    }

    public function activitymade(){    
        return view('activity');   
    }
}
