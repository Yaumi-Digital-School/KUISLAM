<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        return Question::all();
    }

    public function create(request $request){
        $question = new Question;
        $question->question =$request->question;
        $question->image = $request->image;
        $question->option1 = $request->option1;
        $question->option2 = $request->option2;
        $question->option3 = $request->option3;
        $question->option4 = $request->option4;

        $question->timer = $request->timer;
        $question->save();
    }

    public function update(request $request, $id){
        $question = Question::find($id);

        $question->nama = $request->$question;
        $question->image = $request->image;
        $question->option1 = $request->option1;
        $question->option2 = $request->option2;
        $question->option3 = $request->option3;
        $question->option4 = $request->option4;

        $question->timer = $request->timer;
        $question->save();
    }

    public function delete($id){
        $question = Question::find($id);
        $question->delete();
    }
}
