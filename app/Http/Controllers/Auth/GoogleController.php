<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use phpDocumentor\Reflection\Types\Null_;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->getId())->first();
            $findEmail = User::where('email', $user->getEmail())->where('google_id', Null)->first();
            
            /* Versi Google MENERIMA input data email yang telah terdaftar */
            if($findUser){
                Auth::login($findUser);

                return redirect()->intended('dashboard');
            }else{
                if($findEmail){
                    $newUser = User::where('email', $user->getEmail())->update([
                        'google_id' => $user->getId(),
                    ]);
                    Auth::login($findEmail);
    
                    return redirect()->intended('dashboard');
                }

                $password = User::generatePassword();

                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'username' => $user->getEmail(),
                    'password' => Hash::make($password),
                    'avatar' => $user->getAvatar(),
                    'google_id' => $user->getId(),
                ]);
                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
