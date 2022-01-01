<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // route : questions (GET)
        // route name : questions.index
        $questions = Question::getAllQuestion();
        return view('admin.questions', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // route : questions/create (GET)
        // route name : questions.create

        $quizzes = Quiz::all();
        return view('admin.question-form', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // route : questions (POST)
        // route name : questions.store
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'option_1' => 'required|max:255',
            'option_2' => 'required|max:255',
            'option_3' => 'required|max:255',
            'option_4' => 'required|max:255',
            'answer' => 'required',
            'timer' => 'required|numeric|min:45|max:60',
        ]);
        // dd($request->input());
        $dataQuestion = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'image' => $request->image,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'timer' => $request->timer
        ];
        Question::create($dataQuestion);
        return redirect()->route('questions.index')->with('message', 'Question berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // route : questions/{question} (GET)
        // route name : questions.show
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // route : questions/{question}/edit (GET)
        // route name : questions.edit
        // dd($questionEdit);
        $quizzes = Quiz::all();
        $editQuestion = Question::find($id);
        return view('admin.question-form', compact('quizzes', 'editQuestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // route : questions/{question} (PUT)
        // route name : questions.update

        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'option_1' => 'required|max:255',
            'option_2' => 'required|max:255',
            'option_3' => 'required|max:255',
            'option_4' => 'required|max:255',
            'answer' => 'required',
            'timer' => 'required|numeric|min:45|max:60',
        ]);

        $dataQuestion = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'image' => $request->image,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'answer' => $request->answer,
            'timer' => $request->timer
        ];
        Question::updateQuestion($id, $dataQuestion);
        return redirect()->route('questions.index')->with('message', "Question berhasil diedit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // route : questions/{question} (DELETE)
        // route name : questions.destroy
        Question::deleteQuestion($id);
        // return response()->json(['message' => 'Quiz berhasil dihapus']);
        return redirect()->route('questions.index')->with('message', "Question berhasil dihapus");
    }
}
