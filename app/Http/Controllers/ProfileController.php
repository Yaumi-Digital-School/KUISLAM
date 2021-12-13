<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function detailAccount(){
        return view('v_detailAccount');
    }

    public function updateAccount(ProfileRequest $request){
        if ($request->avatar <> "") {
            // Jika ingin ganti Avatar
            $imageAvatar = $request->avatar;
            $avatarFile = $request->name."Avatar.".$imageAvatar->extension();
            $imageAvatar->move(storage_path('app/public/user/avatar'), $avatarFile);

            $dataUser = [
                'name' => $request->name,
                'avatar' => $avatarFile,
            ];
            User::where('id', Auth::user()->id)->update($dataUser);
        }
        else {
            // Jika tidak ingin ganti Avatar
            $dataUser = [
                'name' => $request->name,
            ];
            User::where('id', Auth::user()->id)->update($dataUser);
        }

        return redirect()->back();
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
            Auth::user()->update($data);

            return back()->with('success', 'Success change your password');
        }else{
            return back()->withErrors(['old_password' => 'Make sure you fill your current password']);
        }
    }
}
