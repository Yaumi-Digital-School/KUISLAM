<?php

namespace App\Http\Controllers\import;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function show(){
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.import.users.users', compact('users'));
    }
    
    public function store(){
        $file = Request()->file('file');

        Excel::import(new UsersImport, $file);

        return back()->with('success', 'Berhasil!');
    }

    public function changeRole($userId){
        $user = User::find($userId);
        if($user->role == "admin"){
            $dataUser = [
                'role' => 'user',
            ];
        }else {
            $dataUser = [
                'role' => 'admin',
            ];
        }
        $user->update($dataUser);

        return redirect()->route('users.index')->with('message', 'Role berhasil diubah!');
    }
}
