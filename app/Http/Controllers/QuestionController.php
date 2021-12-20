<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

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
        // return view('v_questions', compact('questions'));
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
        // route name : questions.create
        $dataQuestion = [
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
        return redirect()->route('questions.index');
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
        return '<h1> ini halaman berisi FORM untuk EDIT question dengan id = ' . $id . '</h1>';
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
        $dataQuestion = [
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
        return redirect()->route('questions.index');
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
        return redirect()->route('questions.index');
    }
}
