<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        // Method ini benar, bisa juga gini :
        // Question::get();
        // method get() dan all() akan mengirim collection data, artinya ada lebih dari 1 row data bisa 2 row, 3 row dst....
        return Question::all();
    }

    public function create(request $request){
        // ini ada script yang lebih mudah
        // $data = [
        //     'nama_atribut' => 'vakue yang ingin diisi'
        // ]
        // di php array di atas disebut array associative
        // Question::create($data);

        // biasanya kalau abis create data kita redirect ke halaman tertentu
        // scriptnya gini : return redirect->route('nama.route');

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
        // update juga sama dengan create
        // $data = [
        //     'nama_atribut' => 'vakue yang ingin diisi'
        // ]

        // Question::where('nama_atribut', $id)->update($data);
        // itu cara bacanya, update data dari tabel question ketika id = $id

        // biasanya kalau abis update data kita redirect ke halaman tertentu juga
        // scriptnya gini : return redirect->route('nama.route');
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
        // ini juga bisa scriptnya cuma ada yang lebih mudah
        // Question::where('nama_atribut', $id)->delete();

        $question = Question::find($id);
        $question->delete();
    }
}
