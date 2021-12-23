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
        $leaderboard = Leaderboard::getAllLeaderboard();
        
        return view('v_leaderboard', compact('leaderboard'));
    }    
}
