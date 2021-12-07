<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoomUser;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index(Leaderboard $leaderboard){
        /* Ini harusnya ketrigger ketika room telah berakhir */
        // $roomUser = RoomUser::where('user_id', Auth::user()->id)->where('is_active', false)->first();
        // $currentPoint = Leaderboard::where('user_id', Auth::user()->id)->first();
        // dd($currentPoint->point);
        // Leaderboard::where('user_id', $roomUser->user_id )->update([
        //     'point' => $currentPoint->point + $roomUser->point,
        // ]);

        $leaderboard = Leaderboard::getAllLeaderboard();
        
        return view('v_leaderboard', compact('leaderboard'));
    }    
}
