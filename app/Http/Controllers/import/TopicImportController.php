<?php

namespace App\Http\Controllers\import;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Imports\TopicsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TopicImportController extends Controller
{
    public function show(){
        $topics = Topic::latest()->paginate(10);
        return view('admin.import.topics.topics', compact('topics'));
    }
    
    public function store(){
        $file = Request()->file('file');

        Excel::import(new TopicsImport, $file);

        return back()->with('success', 'Berhasil!');
    }
}
