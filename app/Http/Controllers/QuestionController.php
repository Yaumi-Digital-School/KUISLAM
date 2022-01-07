<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\RoomQuestion;
use App\Models\UserQuestionRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;

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
    public function store(QuestionRequest $request)
    {
        // route : questions (POST)
        // route name : questions.store
        
        $imageImage = $request->image;
        $trimQuestion = Str::limit($request->question, 20);
        $imageName = $request->quiz_id . $trimQuestion . "Image." . $imageImage->extension();
        $imageImage->move(storage_path('app/public/question/image'), $imageName);

        $dataQuestion = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'image' => $imageName,
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
    public function update(QuestionRequest $request, $id)
    {
        // route : questions/{question} (PUT)
        // route name : questions.update

        if ($request->image) {
            // Jika ingin ganti Image
            $imageImage = $request->image;
            $trimQuestion = Str::limit($request->question, 20);
            $imageName = $request->quiz_id . $trimQuestion . "Image." . $imageImage->extension();
            $imageImage->move(storage_path('app/public/question/image'), $imageName);

            $dataQuestion = [
                'quiz_id' => $request->quiz_id,
                'question' => $request->question,
                'image' => $imageName,
                'option_1' => $request->option_1,
                'option_2' => $request->option_2,
                'option_3' => $request->option_3,
                'option_4' => $request->option_4,
                'answer' => $request->answer,
                'timer' => $request->timer
            ];
            Question::updateQuestion($id, $dataQuestion);
        }

        // Jika tidak ingin ganti Image
        $dataQuestion = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
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
        $roomQuestion = RoomQuestion::where('question_id', $id)->first();
        $UserQuestionRoom = UserQuestionRoom::where('question_id', $id)->first();

        if($roomQuestion || $UserQuestionRoom){
            return back()->with('message', "Question gagal dihapus");
        }
        Question::deleteQuestion($id);
        // return response()->json(['message' => 'Quiz berhasil dihapus']);
        return redirect()->route('questions.index')->with('message', "Question berhasil dihapus");
    }
}
