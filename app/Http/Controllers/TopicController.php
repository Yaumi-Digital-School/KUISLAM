<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

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
        $topic = Topic::all()->sortBy('title');
        // return view('v_topics', compact('topic'));
        return '<h1> ini halaman untuk list topic</h1>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // route : topics/create (GET)
        // route name : topics.create
        return '<h1> ini halaman berisi FORM untuk CREATE topic</h1>';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // route : topics (POST)
        // route name : topics.create
        $data = [
            'title' => $request->title,
        ];
        Topic::create($data);
        return redirect()->route('topics.index');
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
    public function update(Request $request, $id){
        // route : topics/{topic} (PUT)
        // route name : topics.update
        $data = [
            'title' => $request->title,
        ];
        Topic::where('id', $id)->update($data);
        return redirect()->route('topics.index');
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
        Topic::where('id', $id)->delete();
        return redirect()->route('topics.index');
    }
}
