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
        // Check if user is in a room
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('status', 'waiting')->first();
    }

    public static function getAllWaitingPlayer($code){
        // Get All player data in waiting room
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->get();
    }

    public static function getAllDoneQuiz(){
        // Get All done quiz
        return RoomUser::where('user_id', Auth::user()->id)->where('status', 'done')->get();
    }

    public static function updateOngoingRoomUser($code, $dataRoomUser){
        // update data in room_users table
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->where('status', 'waiting')->update($dataRoomUser);
    }

    public static function updateDoneRoomUser($code, $dataRoomUser){
        // update data in room_users table
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->where('status', 'ongoing')->update($dataRoomUser);
    }

    public static function updateRoomUserByUserId($code, $dataRoomUser){
        // update data in room_users table by user_id
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('status', 'ongoing')->update($dataRoomUser);
    }

    public static function deleteRoomUserByCode($code){
        // delete data in room_users table by code
        $room = Room::getRoomByCode($code);
        return RoomUser::where('room_id', $room->id)->delete();
    }

    public static function deleteRoomUserByUserId($code){
        // delete data in room_users table by user_id
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->delete();
    }

    public static function isHost($code){
        // check if user is host
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', true)->where('status', 'waiting')->first();
    }

    public static function isPlayer($code){
        // check if user is player
        $room = Room::getRoomByCode($code);
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $room->id)->where('is_host', false)->where('status', 'waiting')->first();
    }

    public static function getPlayerCurrentPoint($roomId){
        // get player current point
        return RoomUser::where('user_id', Auth::user()->id)->where('room_id', $roomId)->first();
    }

    public static function getTop5Rank($roomId){
        // get top 5 rank
        return RoomUser::where('room_id', $roomId)->where('status', 'ongoing')->limit(5)->get()->SortByDesc('points');
    }
}
