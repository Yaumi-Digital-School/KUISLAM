<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function detailAccount(){
        $file = User::authUserImageIsFile(Auth::user()->avatar);

        return view('detail-account', compact('file'));  
    }

    public function updateAccount(ProfileRequest $request){
        if ($request->avatar) {
            // Jika ingin ganti Avatar
            $imageAvatar = $request->avatar;
            $avatarFile = Auth::user()->username . "." . $imageAvatar->extension();
            $imageAvatar->move(storage_path('app/public/user/avatar'), $avatarFile);

            $dataUser = [
                'name' => $request->name,
                'username' => $request->username,
                'avatar' => $avatarFile,
            ];
            User::where('id', Auth::user()->id)->update($dataUser);
        }else {
            // Jika tidak ingin ganti Avatar
            $dataUser = [
                'name' => $request->name,
                'username' => $request->username,
            ];
            User::where('id', Auth::user()->id)->update($dataUser);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function changePassword(Request $request){
        request()->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $currentPassword = Auth::user()->password;
        $oldPassword = $request->old_password;

        if(Hash::check($oldPassword, $currentPassword)){
            $data = [
                'password' => Hash::make($request->password),
            ];
            User::where('id', Auth::user()->id)->update($data);

            return back()->with('success', 'Data berhasil disimpan!');
        }else{
            return back()->with(['failed' => 'Password tidak sesuai']);
        }
    }
}
