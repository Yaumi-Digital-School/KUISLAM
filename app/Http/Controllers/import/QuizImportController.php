<?php

namespace App\Http\Controllers\import;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Imports\QuizzesImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class QuizImportController extends Controller
{
    public function show(){
        $quizzes = Quiz::latest()->paginate(10);
        return view('admin.import.quizzes.quizzes', compact('quizzes'));
    }
    
    public function store(){
        $file = Request()->file('file');

        Excel::import(new QuizzesImport, $file);

        return back()->with('success', 'Berhasil!');
    }
}
