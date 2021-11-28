<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct(){
        $this->User = new User();
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->getId())->first();
            // dd($findUser);

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }else{
                // Available alpha caracters
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                // generate a pin based on 2 * 7 digits + a random character
                $pin = mt_rand(1000000, 9999999)
                    . mt_rand(1000000, 9999999)
                    . $characters[rand(0, strlen($characters) - 1)];

                // shuffle the result
                $password = str_shuffle($pin);

                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'username' => $user->getEmail(),
                    'password' => bcrypt($password),
                    'avatar' => $user->getAvatar(),
                    'role' => 'user',
                    'google_id' => $user->getId(),
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');

                // event(new Registered($newUser));

                // Auth::login($newUser);

                // return redirect(RouteServiceProvider::HOME);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
