<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Leaderboard $leaderboard){
        $leaderboard = Leaderboard::all()->sortByDesc('point');
        // dd($leaderboard);
        return view('v_leaderboard', compact('leaderboard'));
    }
}
