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
    public function preWaitingHost($slug){
        /* 
            Method ini untuk membuat Room.
            Pre-Waiting room - peserta calon moderator.
            Jika merujuk ke desain method ini akan di panggil ketika 
            user memasukkan link share untuk join ke room atau setelah
            user menginput data kode room pada field yang tersedia.
        */

        $quiz = Quiz::getQuizSlug($slug);

        return view('host.prewaiting-room', compact('quiz'));
    }

    public function makeRoom($slug){
        /* 
            Method ini untuk membuat Room
            Pre-Waiting room - peserta calon moderator 
            Jika merujuk ke desain method ini akan di panggil ketika user menekan tombol 
            create room.
        */

        $code = Room::getCode();

        $dataRoom = [
            'quiz_id' => Quiz::getQuizSlug($slug)->id,
            'code' => $code,
        ];
        $room = Room::create($dataRoom);

        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 1,
            'is_active' => 1
        ]; 
        RoomUser::create($dataRoomUser);

        return redirect()->route('room.waiting', $room->code);
    }

    public function startRoom($code){
        /* 
            Method ini untuk memulai Room
            Waiting room - peserta calon moderator 
            Jika merujuk ke desain method ini akan di panggil ketika user (host) menekan tombol 
            START
        */

        $room = Room::getRoomByCode($code);
        
        $quizId = $room->quiz_id;

        $questionsId = Question::getRandomQuestion($quizId);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionsId[$i],
                'room_id' => $room->id,
                'order' => $i+1,
            ];
            RoomQuestion::create($dataRoomQuestion);
        }

        return redirect()->route('room.view-quiz', [
            'code' => $code, 
            'order' => 1
        ]);
    }

    public function viewQuiz($code, $order){
        /* 
            Method ini untuk memulai Room
            Waiting room - peserta calon moderator 
            Jika merujuk ke desain method ini akan di panggil ketika user (host) menekan tombol 
            START
        */

        $room = Room::getRoomByCode($code);
        
        $quizId = $room->quiz_id;

        $questionsId = Question::getRandomQuestion($quizId);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionsId[$i],
                'room_id' => $room->id,
                'order' => $i+1,
            ];
            RoomQuestion::create($dataRoomQuestion);
        }

        return redirect()->route('room.view-quiz', [
            'code' => $code, 
            'order' => $order+1
        ]);
    }

    public function joinRoomWithLink($code){  
        /* 
            Method ini dipanggil ketika User memasukkan link kedalam URL 
        */

        $room = Room::getRoomByCode($code);

        return redirect()->route('room.pre-waiting-player', $room->code);
    }

    public function joinRoomWithCode(Request $request){  
        /* 
            Method ini dipanggil ketika USER menginput CODE Room
            Jika merujuk ke desain method ini akan di panggil ketika 
            user menekan tombol Gabung setelah menginput data kode room 
        */

        $request->validate([
            'code' => ['required', 'integer', 'digits:6']
        ]);

        $room = Room::getRoomByCode($request->code);

        if(!$room){
            return back()->withErrors(['code' => 'Invalid code!']);
        }

        return redirect()->route('room.pre-waiting-player', $room->code);
    }

    public function preWaitingPlayer($code){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        /* Pre-Waiting room - peserta */
        /* Jika merujuk ke desain method ini akan di panggil ketika 
        user memasukkan link share untuk join ke room atau setelah
        user menginput data kode room pada field yang tersedia */

        $room = Room::getRoomByCode($code);
        // return 'Ini page wating player';
        return view('user.prewaiting-room', compact('room'));
    }

    public function enterRoom($code){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        /* Pre-Waiting room - peserta */
        /* Jika merujuk ke desain method ini akan di panggil ketika 
        user menekan tombol join */

        $room = Room::getRoomByCode($code);
        
        if($room){
            $dataRoomUser = [
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'is_host' => 0,
                'is_active' => 1
            ];
            RoomUser::create($dataRoomUser);
    
            return redirect()->route('room.waiting', $room->code);      
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function waitingRoom($code){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        /* Waiting room - peserta */

        $isInRoom = RoomUser::isInRoom($code);
        
        if($isInRoom){
            $roomUser = RoomUser::getAllWaitingPlayer($code);
            $room = Room::getRoomByCode($code);
            
            return view('user.waiting-room', compact('roomUser', 'room'));
        }else{
            return redirect()->route('index');
        }        
    }

    public function exitRoom($code){
        $host = RoomUser::isHost($code);
        $player = RoomUser::isPlayer($code);

        if($host){
            /* Method ini dipanggil ketika room Master / moderator keluar */
            RoomUser::deleteRoomUserByCode($code);
            RoomQuestion::deleteRoomQuestion($code);
            Room::deleteRoomByCode($code);

            return redirect()->route('dashboard');
        }elseif ($player){
            /* Method ini dipanggil ketika player / peserta keluar */
            RoomUser::deleteRoomUserByUserId();
            
            return redirect()->route('dashboard');
        }
    }
}
