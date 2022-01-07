<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Quiz;
use App\Models\Room;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Topic $topic){
        // route : topics (GET)
        // route name : topics.index
        $topics = Topic::orderBy('updated_at', 'desc')->get();
        // dd($topics);
        return view('admin.topics', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // route : topics/create (GET)
        // route name : topics.create
        return view('admin.import.topics.topics-create');;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request){
        // route : topics (POST)
        // route name : topics.store

        $title =  $request->title;

        // dd($title);
        $data = [
            'title' => $title,
            'slug' => Str::slug($title, '-'),
        ];

        Topic::create($data);
        return response()->json(['success' => $data ]);

        // return redirect()->route('topics.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        // route : topics/{topic} (GET)
        // route name : topics.show

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        // route : topics/{topic}/edit (GET)
        // route name : topics.edit
        return '<h1> ini halaman berisi FORM untuk EDIT topic dengan id = ' . $id . '</h1>';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, $id){
        // route : topics/{topic} (PUT)
        // route name : topics.update
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
        ];
        Topic::updateTopic($id, $data);
        // return redirect()->route('topics.index');
        return response()->json(['success' => $data ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        // route : topics/{topic} (DELETE)
        // route name : topics.destroy
        $quiz = Quiz::where('topic_id', $id)->first();
        if($quiz){
            return back()->with('message', 'Quiz gagal dihapus');
        }
        Topic::deleteTopic($id);
        // return redirect()->route('topics.index');
        return response()->json(['success' => "Topic berhasil dihapus"]);
    }
}
