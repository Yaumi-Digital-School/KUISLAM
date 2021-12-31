<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use App\Models\Topic;
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
        $quizzes = Quiz::getAllQuiz();
        // return view('v_quizzes', compact('quiz'));
        return view('admin.quizzes', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // route : quizzes/create (GET)
        // route name : quizzes.create
        $topics = Topic::all(); 
        return view('admin.quiz-form', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request){
        // route : quizzes (POST)
        // route name : quizzes.store
        $slug = Str::slug($request->title);
        $imageName = $slug . '.jpg';
        // dd($request->input());
        $data = [
            'topic_id' => $request->topic_id,
            'slug' => $slug,
            'title' => $request->title,
            'image' => $imageName,
            'description' => $request->description,
            'counter' => '0',
        ];
        Quiz::create($data);
        
        return redirect()->route('quizzes.index')->with('message', 'Quiz berhasil disimpan');
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
        $topics = Topic::all();
        $editQuiz = Quiz::find($id);
        // dd($editQuiz);
        return view('admin.quiz-form', compact('topics', 'editQuiz'));
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
        if ($request->image) {
            // Jika ingin ganti Image
            $imageImage = $request->image;
            $imageFile = $request->title."Image.".$imageImage->extension();
            $imageImage->move(storage_path('app/public/quiz/image'), $imageFile);

            $data = [
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'image' => $imageFile
            ];
            Quiz::updateQuiz($id, $data);
        }else {
            // Jika tidak ingin ganti Image
            $data = [
                'topic_id' => $request->topic_id,
                'title' => $request->title,
            ];
            Quiz::updateQuiz($id, $data);
        }
        return redirect()->route('quizzes.index')->with('message', 'Quiz berhasil diubah');
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
        // return redirect()->route('quizzes.index');
        return response()->json(['message' => 'Quiz berhasil dihapus']);
    }
}
