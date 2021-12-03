<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Room;
use App\Models\Question;
use App\Models\RoomUser;
use App\Models\RoomQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function makeRoom($quizId){
        /* Method ini untuk membuat Room */
        $code = Room::getCode();

        $questionId = Question::getRandomQuestion($quizId);

        $dataRoom = [
            'quiz_id' => Quiz::getQuizId($quizId)->id,
            'code' => $code,
        ];        
        $room = Room::create($dataRoom);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionId[$i],
                'room_id' => $room->id,
            ];
            RoomQuestion::create($dataRoomQuestion);
        }

        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 1,
            'is_active' => 1
        ];        
        RoomUser::create($dataRoomUser);

        return redirect()->route('room.waiting', $room->code);
    }

    public function joinRoomWithLink($code){  
        /* Method ini dipanggil ketika User memasukkan link kedalam URL */
        $room = Room::getRoomByCode($code);

        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        
        RoomUser::create($dataRoomUser);
        return redirect()->route('room.waiting', $room->code);
    }

    public function enterCode(){  
        /* Method ini dipanggil ketika USER ingin menginput CODE Room melalui FORM */
        return view('v_enterCode');
    }

    public function joinRoomWithCode(Request $request){  
        /* Method ini dipanggil ketika USER menginput CODE Room */
        $room = Room::getRoomByCode($request->code);

        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 0,
            'is_active' => 1
        ];
        RoomUser::create($dataRoomUser);

        return redirect()->route('room.waiting', $room->code);
    }

    public function waitingRoom($code, RoomUser $roomUser){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        $isInRoom = RoomUser::isInRoom($code);
        // dd($isInRoom);
        if($isInRoom){
            $roomUser = RoomUser::getAllWaitingPlayer($code);

            return view('v_waitingroom', compact('roomUser'));
        }else{
            return redirect()->route('dashboard');
        }        
    }

    public function exitRoom($code){
        /* Method ini dipanggil ketika Room tidak jadi digunakan atau ketika room Master keluar */
        $host = RoomUser::isHost($code);
        $player = RoomUser::isPlayer($code);

        if($host){
            RoomUser::deleteRoomUserByCode($code);
            RoomQuestion::deleteRoomQuestion($code);
            Room::deleteRoomByCode($code);

            return redirect()->route('dashboard');
        }elseif ($player){
            RoomUser::deleteRoomUserByUserId();
            
            return redirect()->route('dashboard');
        }
    }
}
