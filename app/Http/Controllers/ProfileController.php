<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

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
}
