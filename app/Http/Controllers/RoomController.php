<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RoomUser;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function __construct(){
        $this->RoomUser = new RoomUserController();
    }

    public function getQuizId($id){
        return Quiz::where('id', $id)->first();
    }

    public function getCode(){
        return mt_rand(100000, 999999);
    }

    public function getAllPlayer($id){
        return RoomUser::where('room_id', $id)->get();
    }

    public function createRoom($data){
        return Room::create($data);
    }

    /* Method ini untuk membuat Room */
    public function makeRoom($id){  
        $dataRoom = [
            'quiz_id' => $this->getQuizId($id)->id,
            'code' => $this->getCode(),
        ];
        
        $room = $this->createRoom($dataRoom);

        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 1,
            'is_active' => 1
        ];
        
        $this->RoomUser->createRoomUser($dataRoomUser);
        return redirect()->route('room.waiting', $room->id);
    }

    /* Method ini dipanggil ketika User menginput code Room */
    public function joinRoom($id){  
        // dd($this->getCode());
        // $dataRoom = [
        //     'quiz_id' => $this->getQuizId($id)->id,
        //     'code' => $this->getCode(),
        // ];
        
        // $room = $this->createRoom($dataRoom);
        // dd($room->id);

        // $dataRoomUser = [
        //     'user_id' => Auth::user()->id,
        //     'room_id' => $room->id,
        //     'is_host' => 1,
        //     'is_active' => 1
        // ];
        
        // $this->RoomUser->createRoomUser($dataRoomUser);
        // return redirect()->route('room.waiting', $room->id);
    }

    /* Method ini dipanggil ketika Room berhasil dibuat */
    public function waitingRoom($id, RoomUser $roomUser){
        $roomUser = $this->getAllPlayer($id);
        return view('v_waitingroom', compact('roomUser'));
    }
}
