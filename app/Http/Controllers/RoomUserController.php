<?php

namespace App\Http\Controllers;

use App\Models\RoomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomUserController extends Controller
{
    public function createRoomUser($data){
        return RoomUser::insert($data);
    }

    public function deleteRoomUserBasedOnRoomId($roomId){
        return RoomUser::where('room_id',$roomId)->delete();
    }
    public function deleteRoomUserBasedOnUserId($userId, $roomId){
        return RoomUser::where('user_id', $userId)->where('room_id', $roomId)->delete();
    }

    public function isHost($userId){
        return RoomUser::where('user_id', $userId)->where('is_host', true)->where('is_active', 1)->first();
    }

    public function isPlayer($userId){
        return RoomUser::where('user_id', $userId)->where('is_host', false)->where('is_active', 1)->get();
    }
}
