<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        // Method ini benar, bisa juga gini :
        //Question::get();
        // method get() dan all() akan mengirim collection data, artinya ada lebih dari 1 row data bisa 2 row, 3 row dst....
        return Question::all();
    }

    public function create(request $request){
        // ini ada script yang lebih mudah
        $question = [
            'question' => $request->question,
            'image' => $request->image,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'timer' => $request->timer
        ];
        Question::create($question);

        // di php array di atas disebut array associative

        // biasanya kalau abis create data kita redirect ke halaman tertentu
        // scriptnya gini : return redirect->route('nama.route');

        // $question = new Question;
        // $question->question =$request->question;
        // $question->image = $request->image;
        // $question->option1 = $request->option1;
        // $question->option2 = $request->option2;
        // $question->option3 = $request->option3;
        // $question->option4 = $request->option4;

        // $question->timer = $request->timer;
        // $question->save();

        //return redirect->route('question');
        return redirect()->route('dashboard');

    }

    public function update(request $request, $id){
        // update juga sama dengan create
        $question = [
            'question' => $request->question,
            'image' => $request->image,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'timer' => $request->timer
        ];

        Question::where('id', $id)->update($question);
        // itu cara bacanya, update data dari tabel question ketika id = $id

        // biasanya kalau abis update data kita redirect ke halaman tertentu juga
        // scriptnya gini : return redirect->route('nama.route');

        // $question = Question::find($id);
        // $question->nama = $request->$question;
        // $question->image = $request->image;
        // $question->option1 = $request->option1;
        // $question->option2 = $request->option2;
        // $question->option3 = $request->option3;
        // $question->option4 = $request->option4;

        // $question->timer = $request->timer;
        // $question->save();

        return redirect()->route('dashboard');
    }

    public function delete($id){
        // ini juga bisa scriptnya cuma ada yang lebih mudah
        Question::where('id', $id)->delete();
        return redirect()->route('dashboard');

        // $question = Question::find($id);
        // $question->delete();
    }
}
