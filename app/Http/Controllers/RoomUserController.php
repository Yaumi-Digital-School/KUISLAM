<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomUserController extends Controller
{
    public function __construct(){
        $this->Room = new RoomController();
    }

    public function getAllPlayedQuiz(){
        $room = RoomUser::where('user_id', Auth::id())->where('is_active', false)->get();

        dd($room);
    }
    
    public function createRoomUser($data){
        return RoomUser::insert($data);
    }

    public function deleteRoomUserByCode($code){
        $room = $this->Room->getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->delete();
    }

    public function deleteRoomUserByUserId($userId, $code){
        $room = $this->Room->getRoomByCode($code);
        return RoomUser::where('user_id', $userId)->where('room_id', $room->id)->delete();
    }

    public function isHost($code){
        $room = $this->Room->getRoomByCode($code);
        return RoomUser::where('user_id', Auth::id())->where('room_id', $room->id)->where('is_host', true)->where('is_active', 1)->first();
    }

    public function isPlayer($code){
        $room = $this->Room->getRoomByCode($code);
        return RoomUser::where('user_id', Auth::id())->where('room_id', $room->id)->where('is_host', false)->where('is_active', 1)->get();
    }
}
