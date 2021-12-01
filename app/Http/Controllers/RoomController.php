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

    public function getQuizId($quizId){
        return Quiz::where('id', $quizId)->first();
    }

    public function getCode(){
        return mt_rand(100000, 999999);
    }

    public function getRoomBasedOnCode($code){
        return Room::where('code', $code)->first();
    }

    public function getAllWaitingPlayer($roomId){
        return RoomUser::where('room_id', $roomId)->where('is_active', true)->get();
    }

    public function createRoom($data){
        return Room::create($data);
    }

    public function deleteRoom($id){
        return Room::where('id', $id)->delete();
    }

    public function makeRoom($quizId){
        /* Method ini untuk membuat Room */
        $code = $this->getCode();
        $dataRoom = [
            'quiz_id' => $this->getQuizId($quizId)->id,
            'code' => $code,
        ];
        
        $room = $this->createRoom($dataRoom);

        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 1,
            'is_active' => 1
        ];
        
        $this->RoomUser->createRoomUser($dataRoomUser);
        return redirect()->route('room.waiting', $room->id);
    }

    public function joinRoomWithLink($code){  
        /* Method ini dipanggil ketika User memasukkan link kedalam URL */
        $room = $this->getRoomBasedOnCode($code);

        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        
        $this->RoomUser->createRoomUser($dataRoomUser);
        return redirect()->route('room.waiting', $room->id);
    }

    public function enterCode(){  
        /* Method ini dipanggil ketika User ingin menginput code Room */
        return view('v_enterCode');
    }

    public function joinRoomWithCode(Request $request){  
        /* Method ini dipanggil ketika User menginput code Room */
        $room = $this->getRoomBasedOnCode($request->code);
        dd($room->id);
    
        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        
        $this->RoomUser->createRoomUser($dataRoomUser);
        return redirect()->route('room.waiting', $room->id);
    }

    public function waitingRoom($roomId, RoomUser $roomUser){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        $roomUser = $this->getAllWaitingPlayer($roomId);
        return view('v_waitingroom', compact('roomUser'));
    }

    public function exitRoom($roomId){
        /* Method ini dipanggil ketika Room tidak jadi digunakan atau ketika room Master keluar */
        $host = $this->RoomUser->isHost(Auth::id());
        $player = $this->RoomUser->isPlayer(Auth::id());

        if($host){
            $this->RoomUser->deleteRoomUserBasedOnRoomId($roomId);
            $this->deleteRoom($roomId);
        }elseif ($player){
            $this->RoomUser->deleteRoomUserBasedOnUserId(Auth::id(), $roomId);
        }
        
        return redirect()->route('dashboard');
    }
}
