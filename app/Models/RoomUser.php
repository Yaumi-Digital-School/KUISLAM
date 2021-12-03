<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoomUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isInRoom($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_active', true)->first();
    }

    public static function getAllWaitingPlayer($code){
        $room = Room::where('code', $code)->first();
        return RoomUser::where('room_id', $room->id)->get();
    }

    public static function deleteRoomUserByCode($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->delete();
    }

    public static function deleteRoomUserByUserId(){
        $room = Room::getRoomById(Auth::user()->id);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->delete();
    }

    public static function isHost($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', true)->where('is_active', 1)->first();
    }

    public static function isPlayer($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', false)->where('is_active', 1)->get();
    }
}
