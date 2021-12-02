<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Room;
use App\Models\Question;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoomUserController;
use App\Http\Controllers\RoomQuestionController;

class RoomController extends Controller
{
    public function __construct(){
        $this->RoomUser = new RoomUserController();
        $this->Question = new QuestionController();
        $this->RoomQuestion = new RoomQuestionController();
    }

    public function getQuizId($quizId){
        return Quiz::where('id', $quizId)->first();
    }

    public function getCode(){
        return mt_rand(100000, 999999);
    }

    public function getRoomById($roomId){
        return Room::where('id', $roomId)->first();
    }

    public function getRoomByCode($code){
        return Room::where('code', $code)->first();
    }

    public function getAllWaitingPlayer($code){
        $room = Room::where('code', $code)->first();
        return RoomUser::where('room_id', $room->id)->get();
    }

    public function createRoom($data){
        return Room::create($data);
    }

    public function deleteRoom($id){
        return Room::where('id', $id)->delete();
    }

    public function deleteRoomByCode($code){
        return Room::where('code', $code)->delete();
    }

    public function isInRoom($code){
        $room = $this->getRoomByCode($code);
        return RoomUser::where('user_id', Auth::id())->where('room_id', $room->id)->where('is_active', true)->first();
    }

    // public function verifyToCreateAnotherRoom($roomId){
    //     $room 
    //     $host = RoomUser::where('user_id', Auth::id())->where('is_host', true)->first();
    //     if($host){
    //         return redirect()->route('room.waiting', $code);
    //     }else{
    //         return $this->makeRoom($quizId);
    //     }
    // }


    public function makeRoom($quizId){
        /* Method ini untuk membuat Room */
        $code = $this->getCode();

        $questionId = $this->Question->getRandomQuestion($quizId);

        $dataRoom = [
            'quiz_id' => $this->getQuizId($quizId)->id,
            'code' => $code,
        ];        
        $room = $this->createRoom($dataRoom);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionId[$i],
                'room_id' => $room->id,
            ];
            $this->RoomQuestion->createRoomQuestion($dataRoomQuestion);
        }

        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 1,
            'is_active' => 1
        ];        
        $this->RoomUser->createRoomUser($dataRoomUser);

        return redirect()->route('room.waiting', $room->code);
    }

    public function joinRoomWithLink($code){  
        /* Method ini dipanggil ketika User memasukkan link kedalam URL */
        $room = $this->getRoomByCode($code);

        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        
        $this->RoomUser->createRoomUser($dataRoomUser);
        return redirect()->route('room.waiting', $room->code);
    }

    public function enterCode(){  
        /* Method ini dipanggil ketika USER ingin menginput CODE Room melalui FORM */
        return view('v_enterCode');
    }

    public function joinRoomWithCode(Request $request){  
        /* Method ini dipanggil ketika USER menginput CODE Room */
        $room = $this->getRoomByCode($request->code);

        $dataRoomUser = [
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        $this->RoomUser->createRoomUser($dataRoomUser);

        return redirect()->route('room.waiting', $room->code);
    }

    public function waitingRoom($code, RoomUser $roomUser){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        $isInRoom = $this->isInRoom($code);
        dd($isInRoom);
        if($isInRoom){
            $roomUser = $this->getAllWaitingPlayer($code);

            return view('v_waitingroom', compact('roomUser'));
        }else{
            return redirect()->route('dashboard');
        }        
    }

    public function exitRoom($code){
        /* Method ini dipanggil ketika Room tidak jadi digunakan atau ketika room Master keluar */
        $host = $this->RoomUser->isHost($code);
        $player = $this->RoomUser->isPlayer($code);

        if($host){
            $this->RoomUser->deleteRoomUserByCode($code);
            $this->RoomQuestion->deleteRoomQuestion($code);
            $this->deleteRoomByCode($code);

            return redirect()->route('dashboard');
        }elseif ($player){
            $this->RoomUser->deleteRoomUserByUserId(Auth::id(), $code);
            
            return redirect()->route('dashboard');
        }
        
    }
}
