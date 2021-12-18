<?php

namespace App\Http\Controllers\import;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Imports\QuestionsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class QuestionImportController extends Controller
{
    public function show(){
        $questions = Question::latest()->paginate(10);        
        return view('admin.import.questions.questions', compact('questions'));
    }
    
    public function store(){
        $file = Request()->file('file');

        Excel::import(new QuestionsImport, $file);

        return back()->with('success', 'Berhasil!');
    }
}
