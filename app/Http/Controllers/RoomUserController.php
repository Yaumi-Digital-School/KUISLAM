<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomUserController extends Controller
{
    public function getAllPlayedQuiz(Room $room){
        $room = RoomUser::where('user_id', Auth::user()->id)->where('is_active', false)->get();
        // dd($room);
        return view('v_AllPlayedQuiz', compact('room'));
    }
}
