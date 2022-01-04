<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\RoomUser;
use App\Models\RoomQuestion;
use App\Models\UserQuestionRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function roomquestions()
    {
        return $this->hasMany(RoomQuestion::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function userquestionrooms()
    {
        return $this->hasMany(UserQuestionRoom::class);
    }

    public function roomusers()
    {
        return $this->hasMany(RoomUser::class);
    }

    public static function getCode(){
        return mt_rand(100000, 999999);
    }

    public static function roomIsDone($code){
        return Room::where('code', $code)->where('status', 'done')->first();
    }

    public static function getRoomById($roomId){
        return Room::where('id', $roomId)->first();
    }

    public static function getRoomByCode($code){
        return Room::where('code', $code)->first();
    }

    public static function updateOngoingRoom($code, $data){
        return Room::where('code', $code)->where('status', 'waiting')->update($data);
    }

    public static function updateDoneRoom($code, $data){
        return Room::where('code', $code)->where('status', 'ongoing')->update($data);
    }

    public static function deleteRoom($id){
        return Room::where('id', $id)->where('status', 'waiting')->delete();
    }

    public static function deleteRoomByCode($code){
        return Room::where('code', $code)->where('status', 'waiting')->delete();
    }

    

    // public static function verifyToCreateAnotherRoom($roomId){
    //     $room 
    //     $host = RoomUser::where('user_id', Auth::user()->id)->where('is_host', true)->first();
    //     if($host){
    //         return redirect()->route('room.waiting', $code);
    //     }else{
    //         return $this->makeRoom($quizId);
    //     }
    // }
}
