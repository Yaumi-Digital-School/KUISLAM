<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz){
        // route : quizzes (GET)
        // route name : quizzes.index
        $quiz = Quiz::getAllQuiz();
        // return view('v_quizzes', compact('quiz'));
        return '<h1> ini halaman untuk list quiz</h1>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // route : quizzes/create (GET)
        // route name : quizzes.create
        return '<h1> ini halaman berisi FORM untuk CREATE quiz</h1>';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request){
        // route : quizzes (POST)
        // route name : quizzes.create
        $slug = Str::slug($request->title);
        $imageName = $slug . '.jpg';

        $data = [
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'image' => $imageName
        ];
        Quiz::create($data);
        
        return redirect()->route('quizzes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        // route : quizzes/{quiz} (GET)
        // route name : quizzes.show
        $quiz = Quiz::getOneQuiz($id);

        return '<h1> ini halaman yang berisi detail informasi quiz dengan id = ' . $id . '</h1>';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        // route : quizzes/{quiz}/edit (GET)
        // route name : quizzes.edit
        return '<h1> ini halaman berisi FORM untuk EDIT quiz dengan id = ' . $id . '</h1>';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request, $id){
        // route : quizzes/{quiz} (PUT)
        // route name : quizzes.update
        $slug = Str::slug($request->title);
        $imageName = $slug . '.jpg';

        $data = [
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'image' => $imageName
        ];
        Quiz::updateQuiz($id, $data);

        return redirect()->route('quizzes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        // route : quizzes/{quiz} (DELETE)
        // route name : quizzes.destroy
        Quiz::deleteQuiz($id);
        return redirect()->route('quizzes.index');
    }
}
