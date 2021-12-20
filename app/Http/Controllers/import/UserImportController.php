<?php

namespace App\Http\Controllers\import;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function show(){
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.import.users.users', compact('users'));
    }
    
    public function store(){
        $file = Request()->file('file');

        Excel::import(new UsersImport, $file);

        return back()->with('success', 'Berhasil!');
    }

    public function change($userId){ 
        $dataUser = [
            'role' => 'admin',
        ];
        User::where('id', $userId)->update($dataUser);

        return redirect()->route('import.show.users')->with('success', 'Berhasil!');
    }
}
