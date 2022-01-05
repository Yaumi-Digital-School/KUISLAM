<?php

namespace App\Http\Controllers;

use App\Events\HostCancelRoom;
use Carbon\Carbon;
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
        $slugId = Quiz::getQuizSlug($slug);
        
        $dataRoom = [
            'quiz_id' => $slugId->id,
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
        $currentTime = Carbon::now();
        $leaderboardTime = 10;

        // Check total player in a room
        $countPlayer = RoomUser::getAllWaitingPlayer($code)->count();
        // if total player < 2
        // if($countPlayer < 2){
        //     return back();
        // }

        // get random question
        $questionsId = Question::getRandomQuestion($quizId);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionsId[$i],
                'room_id' => $room->id,
                'order' => $i+1,
            ];
            $roomQuestion = RoomQuestion::create($dataRoomQuestion);

            $tempRoomQuestion = RoomQuestion::where('room_id', $room->id)->get();
            $getTimer = $roomQuestion->question->timer;
            
            if($roomQuestion->order == 1){
                $timeStartInt = strtotime($currentTime->toDateTimeString()) + 5;
                $timeStartDate = date("Y-m-d H:i:s", $timeStartInt);
                $timeEndInt = strtotime($currentTime) + $getTimer + $leaderboardTime;
                $timeEndDate = date("Y-m-d H:i:s", $timeEndInt);
            }elseif($roomQuestion->order > 1){
                $timeStartDate = $tempRoomQuestion[$i-1]->time_end;
                $timeEndInt = strtotime($tempRoomQuestion[$i-1]->time_end) + $getTimer + $leaderboardTime;
                $timeEndDate = date("Y-m-d H:i:s", $timeEndInt);
            }
            RoomQuestion::where('room_id', $room->id)->where('order', $i+1)->update([
                'time_start' => $timeStartDate,
                'time_end' => $timeEndDate,
            ]);        
        }

        $dataRoomUser = [
            'status' => 'ongoing',
        ];
        RoomUser::updateOngoingRoomUser($code, $dataRoomUser);

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
        $roomUser = RoomUser::getPlayerCurrentRoomData($room->id);
        // $allRank = RoomUser::getAllRank($room->id);
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        $currentTime = Carbon::now();
        
        if($savedDataOrder){
            $accessableOrder = $savedDataOrder->order + 1;
        }
        
        if(!$savedDataOrder && intval($order) != 1 && intval($order) != $accessableOrder){
            // User can't move to another order by changing the question order on URL
            return back();
        }

        $timeLeftForQuestion = (strtotime($roomQuestion->time_start) + $roomQuestion->question->timer) - strtotime($currentTime);

        // if user already submit the question 
        if(UserQuestionRoom::where('user_id', Auth::id())
                                    ->where('room_id', $room->id)
                                    ->where('question_id', $roomQuestion->question->id)
                                    ->exists()){
            $user_answer = UserQuestionRoom::where('user_id', Auth::id())
                                    ->where('room_id', $room->id)
                                    ->where('question_id', $roomQuestion->question->id)
                                    ->get()->first()->answer_option;
            // dd($user_answer->answer_option);
            return view('quiz', compact('roomUser', 'roomQuestion', 'code', 'order', 'timeLeftForQuestion', 'user_answer'));
        }

        return view('quiz', compact('roomUser', 'roomQuestion', 'code', 'order', 'timeLeftForQuestion'));
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
        /* Pre-Waiting room - player */
        /* Jika merujuk ke desain method ini akan di panggil ketika 
        user memasukkan link share untuk join ke room atau setelah
        user menginput data kode room pada field yang tersedia */

        $room = Room::getRoomByCode($code);
        if(!$room){
            return redirect()->route('index');
        }

        return view('user.prewaiting-room', compact('room'));
    }

    public function enterRoom($code){
        /* Method ini dipanggil ketika Room berhasil dibuat */
        /* Pre-Waiting room - peserta */
        /* Jika merujuk ke desain method ini akan di panggil ketika 
        user menekan tombol join */

        $room = Room::getRoomByCode($code);
        
        if(!$room){
            return redirect()->route('index'); 
        }
        
        $dataRoomUser = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'is_host' => 0,
            'status' => 'waiting'
        ];
        RoomUser::create($dataRoomUser);
        
        UserJoinedRoom::dispatch('user has joined', $room, ["id" => Auth::user()->id, "name" => Auth::user()->name]);

        return redirect()->route('room.waiting', $room->code);   
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

            HostCancelRoom::dispatch($room->id);

            return redirect()->route('index');
        }elseif ($player){
            /* Method ini dipanggil ketika player / peserta keluar */
            UserExitRoom::dispatch('user has exit', $room, ["id" => Auth::user()->id, "name" => Auth::user()->name]);
            RoomUser::deleteRoomUserByUserId($code);

            return redirect()->route('index');
        }
    }

    public function handleAnswer(Request $request, $code, $order){
        $room = Room::getRoomByCode($code);        
        $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentPoint = RoomUser::getPlayerCurrentRoomData($room->id)->points;
        $currentTotalCorrect = RoomUser::getPlayerCurrentRoomData($room->id)->total_correct;
        $currentAnswer = $request->answer_option;
        $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

        // data to be inserted (default is wrong answer)
        $dataUserQuestionRoom = [
            'user_id' => Auth::user()->id,
            'room_id' => $room->id,
            'question_id' => $questionId->question_id,
            'order' => $order,
            'point' => $currentPoint,
            'answer_option' => $currentAnswer,
            'is_correct' => false,
        ];
        $dataRoomUser = [
            'rank' => $rank,
            'points' => $currentPoint,
        ];

        // If answer correct, update data to correct answer
        if($questionId->question->answer === $currentAnswer){
            $point = ($questionId->question->timer/$questionId->question->timer) * 1000;
            
            $dataUserQuestionRoom['point'] = $currentPoint + $point;
            $dataUserQuestionRoom['is_correct'] = true;

            $dataRoomUser['points'] = $currentPoint + $point;
            $dataRoomUser['total_correct'] = $currentTotalCorrect + 1;
        }
        UserQuestionRoom::create($dataUserQuestionRoom);
        RoomUser::updateRoomUserByUserId($code, $dataRoomUser);   
        
        // return redirect()->route('question.leaderboard', ['room' => $code, 'order' => $order]);
        return response()->json([
            'room' => $code,
            'order' => $order,
            'user_answer' => $currentAnswer
        ]);
    }

    public function leaderboard($code, $order){
        $room = Room::getRoomByCode($code);
        // dd($code);
        $roomUser = RoomUser::getTop5Rank($room->id);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentTime = Carbon::now();

        if(intval($order) === $totalQuestion){
            $timeLeftForLeaderboard = 0;
            $final = true;
            return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard'));
        }
        // elseif(intval($order) != $savedDataOrder->order){
        //     // User can't move to another order by changing the question order on URL
        //     return back();
        // }

        $final = false;
        $timeLeftForLeaderboard = strtotime($roomQuestion->time_end) - strtotime($currentTime);
        
        return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard'));
    }

    public function exitGame($code){
        $dataRoomUser = [
            'status' => 'done',
        ];
        $roomUser = RoomUser::updateDoneRoomUser($code, $dataRoomUser);

        $room = Room::getRoomByCode($code);
        $roomUser = $room->roomusers->first();
        // dd($roomUser->room);
        $host = RoomUser::isHost($code);
        if($host){
            $quiz = Quiz::where('id', $roomUser->room->quiz_id)->first();
            $dataQuiz = [
                'counter' => $quiz->counter + 1,
            ];
            Quiz::where('id', $roomUser->room->quiz_id)->update($dataQuiz);
        }
        
        return redirect()->route('index');
    }

    // public function test($code, $order){
    //     $room = Room::getRoomByCode($code);
    //     $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);
    //     dd($rank);
    // }
}
