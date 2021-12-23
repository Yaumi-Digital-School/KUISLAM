<?php

namespace App\Http\Controllers;

use App\Events\HostStartQuiz;
use App\Models\Quiz;
use App\Models\Room;
use App\Models\Question;
use App\Models\RoomUser;
use App\Events\UserExitRoom;
use App\Models\RoomQuestion;
use Illuminate\Http\Request;
use App\Events\UserJoinedRoom;
use App\Models\UserQuestionRoom;
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
            'status' => 'waiting'
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

        $countPlayer = RoomUser::getAllWaitingPlayer($code)->count();
        if($countPlayer < 2){
            return back();
        }

        $questionsId = Question::getRandomQuestion($quizId);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionsId[$i],
                'room_id' => $room->id,
                'order' => $i+1,
            ];
            RoomQuestion::create($dataRoomQuestion);
        }

        HostStartQuiz::dispatch($code);

        return redirect()->route('question.view', [
            'room' => $code, 
            'order' => 1
        ]);
    }

    public function viewQuestion($code, $order){
        /* 
            Method ini untuk menampilkan Pertanyaan
        */
        $room = Room::getRoomByCode($code);
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
     
        return view('quiz', compact('roomQuestion'));
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
                'status' => 'waiting'
            ];
            RoomUser::create($dataRoomUser);
            
            UserJoinedRoom::dispatch('user has joined', $room, ["id" => Auth::id(), "name" => Auth::user()->name]);

            return redirect()->route('room.waiting', $room->code);      
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function waitingRoom($code){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        /* Waiting room - peserta */

        /* 
            Kalau data Room tidak ada akan redirect ke home
        */
        $room = Room::getRoomByCode($code);
        if(!$room){
            return redirect()->route('index');     
        }
        
        /* 
            Yang tidak terdaftar dalam suatu room tidak bisa masuk
        */
        $isInRoom = RoomUser::isInRoom($code);
        if(!$isInRoom){
            return redirect()->route('index');     
        }

        $host = RoomUser::isHost($code);
        $player = RoomUser::isPlayer($code);

        $roomUser = RoomUser::getAllWaitingPlayer($code);
        $room = Room::getRoomByCode($code);

        if($host){
            return view('host.waiting-room', compact('roomUser', 'room'));
        }elseif ($player){
            return view('user.waiting-room', compact('roomUser', 'room'));
        }       
    }

    public function exitRoom($code){
        $host = RoomUser::isHost($code);
        $player = RoomUser::isPlayer($code);
        $room = Room::getRoomByCode($code);

        if($host){
            /* Method ini dipanggil ketika room Master / moderator keluar */
            RoomUser::deleteRoomUserByCode($code);
            RoomQuestion::deleteRoomQuestion($code);
            Room::deleteRoomByCode($code);

            return redirect()->route('index');
        }elseif ($player){
            /* Method ini dipanggil ketika player / peserta keluar */
            UserExitRoom::dispatch('user has exit', $room, ["id" => Auth::id(), "name" => Auth::user()->name]);
            RoomUser::deleteRoomUserByUserId($code);

            return redirect()->route('index');
        }
    }

    public function handleAnswer(Request $request, $code, $order){
        $room = Room::getRoomByCode($code);
        
        $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);


        $currentPoint = RoomUser::getPlayerCurrentPoint($room->id)->point;

        if($questionId->answer === $request->answer_option){
            // If answer correct
            // $point = ($questionId->timer/$questionId->timer) * 1000; (salah, gaada timer di $questionId)
            $point =  1000;
            
            $dataUserQuestionRoom = [
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'question_id' => $questionId,
                'order' => $order,
                'point' => $currentPoint + $point,
                'answer_option' => $request->answer_option,
                'is_correct' => true,
            ];
            UserQuestionRoom::create($dataUserQuestionRoom);

            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

                        
            if($order == 1){
                $dataRoomUser = [
                    'user_id' => Auth::user()->id,
                    'room_id' => $room->id,
                    'rank' => $rank,
                    'point' => $point,
                ];
                RoomUser::create($dataRoomUser);
            }

            $dataRoomUser = [
                'rank' => $rank,
                'point' => $currentPoint + $point,
            ];
            RoomUser::updateRoomUser($code, $dataRoomUser);   
        }else{
            // If answer wrong
            $dataUserQuestionRoom = [
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'point' => $currentPoint + 0,
                'is_correct' => false,
                'answer_option' => $request->answer_option
            ];
            UserQuestionRoom::create($dataUserQuestionRoom);    

            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

            if($order == 1){
                $dataRoomUser = [
                    'user_id' => Auth::user()->id,
                    'room_id' => $room->id,
                    'rank' => $rank,
                    'point' => 0,
                ];
                RoomUser::create($dataRoomUser);
            }

            $dataRoomUser = [
                'rank' => $rank,
                'point' => $currentPoint + 0,
            ];
            RoomUser::updateRoomUser($code, $dataRoomUser);   
        }

        if($order == 10){
            $dataRoomUser = [
                'status' => 'done',
            ];
            RoomUser::where('room_id', $room->id)->update($dataRoomUser);
        }

        return redirect()->route('question.leaderboard', [
            'room' => $code, 
            'order' => 1
        ]);
    }

    public function leaderboard($code, $order){
        $room = Room::getRoomByCode($code);
        $roomUser = RoomUser::getTop5Rank($room->id);

        $countQuestion = Question::getTotalQuestions($room->quiz_id);

        if($order == $countQuestion){
            $final = true;
            return view('leaderboard', compact('roomUser', 'final', 'order'));
        }elseif($order > $countQuestion || $order < 1){
            return back();
        }

        $final = false;
        return view('leaderboard', compact('roomUser', 'final', 'order'));
    }

    // public function test($code, $order){
    //     $room = Room::getRoomByCode($code);
    //     $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);
    //     dd($rank);
    // }
}
