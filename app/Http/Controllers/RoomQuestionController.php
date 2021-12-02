<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomQuestionController extends Controller
{
    public function __construct(){
        $this->Room = new RoomController();
    }

    public function createRoomQuestion($data){
        return RoomQuestion::create($data);
    }

    public function deleteRoomQuestion($code){
        $room = $this->Room->getRoomByCode($code);
        return RoomQuestion::where('room_id', $room->id)->delete();
    }
}
