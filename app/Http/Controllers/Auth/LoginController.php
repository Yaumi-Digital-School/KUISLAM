<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $findGoogleId = User::where('google_id', $user->getId())->first();
            $findEmailGoogle = User::where('email', $user->getEmail())->where('google_id', Null)->first();
            
            /* Versi Google MENERIMA input data email yang telah terdaftar */
            if($findGoogleId){
                Auth::login($findGoogleId);

                return redirect()->route('index');
            }else{
                if($findEmailGoogle){    
                    return redirect()->route('index')->withErrors('social', 'Email telah terdaftar');
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

                return redirect()->route('index');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(){
        try {
            $user = Socialite::driver('facebook')->user();
            $findFacebookId = User::where('facebook_id', $user->getId())->first();
            $findEmailFacebook = User::where('email', $user->getEmail())->where('facebook_id', Null)->first();
            
            /* Versi Google MENERIMA input data email yang telah terdaftar */
            if($findFacebookId){
                Auth::login($findFacebookId);

                return redirect()->route('index');
            }else{
                if($findEmailFacebook){
                    return redirect()->route('index')->withErrors('social', 'Email telah terdaftar');
                }

                $password = User::generatePassword();

                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'username' => $user->getEmail(),
                    'password' => Hash::make($password),
                    'avatar' => $user->getAvatar(),
                    'facebook_id' => $user->getId(),
                ]);
                Auth::login($newUser);

                return redirect()->route('index');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
