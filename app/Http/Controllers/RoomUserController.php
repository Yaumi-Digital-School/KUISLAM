<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomUserController extends Controller
{
    public function getAllPlayedQuiz(){
        $room = RoomUser::getAllDoneQuiz();
        // dd($room);
        return view('v_AllPlayedQuiz', compact('room'));
    }
}
