<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomUser extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public static function isInRoom($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::id())->where('room_id', $room->id)->where('is_active', true)->first();
    }

    public static function getAllWaitingPlayer($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->get();
    }

    public static function deleteRoomUserByCode($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->delete();
    }

    public static function deleteRoomUserByUserId($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->delete();
    }

    public static function isHost($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', true)->where('is_active', 1)->first();
    }

    public static function isPlayer($code){
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', false)->where('is_active', 1)->first();
    }

    public static function getPlayerCurrentPoint($roomId){
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $roomId)->first();
    }
}
