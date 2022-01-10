<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Room;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuizUser;
use Illuminate\Support\Str;
use App\Http\Requests\QuizRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQuizRequest;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
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

        $slug = Str::slug($request->title, '-');
        $imageImage = $request->image;
        $imageName = $request->title."Image.".$imageImage->extension();
        $imageImage->move(storage_path('app/public/quiz/image'), $imageName);

        $data = [
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'slug' => $slug,
            'image' => $imageName,
            'description' => $request->description,
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
        
        return view('admin.quiz-form', compact('topics', 'editQuiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, $id){
        // route : quizzes/{quiz} (PUT)
        // route name : quizzes.update
        if ($request->image) {
            // Jika ingin ganti Image
            $imageImage = $request->image;
            $imageName = $request->title . "Image." . $imageImage->extension();
            $imageImage->move(storage_path('app/public/quiz/image'), $imageName);

            $data = [
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'image' => $imageName
            ];
            Quiz::updateQuiz($id, $data);
        }

        // Jika tidak ingin ganti Image
        $data = [
            'topic_id' => $request->topic_id,
            'title' => $request->title,
        ];
        Quiz::updateQuiz($id, $data);

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
        $question = Question::where('quiz_id', $id)->first();
        $room = Room::where('quiz_id', $id)->first();
        $quizUser = QuizUser::where('quiz_id', $id)->first();
        if($question || $room || $quizUser){
            return back()->with('message', 'Quiz gagal dihapus');
        }
        Quiz::deleteQuiz($id);
        return redirect()->route('quizzes.index')->with('message', 'Quiz berhasil dihapus');
        // return response()->json(['message' => 'Quiz berhasil dihapus']);
    }
}
