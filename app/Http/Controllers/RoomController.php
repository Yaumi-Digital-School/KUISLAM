<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Room;
use App\Models\Question;
use App\Models\RoomUser;
use App\Events\UserExitRoom;
use App\Models\RoomQuestion;
use Illuminate\Http\Request;
use App\Events\HostStartQuiz;
use App\Events\HostCancelRoom;
use App\Events\UserJoinedRoom;
use App\Models\UserQuestionRoom;
use App\Http\Requests\CodeRequest;
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
        $isInWaitingRoom = RoomUser::isInWaitingRoom();
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
        
        if($isInWaitingRoom){
            // If already in a waiting room
            return redirect()->route('room.waiting', $isInWaitingRoom->room->code)->with('error', 'You already in a waiting room!');
        }elseif($isInOngoingRoom){
            $dataOngoingRoom = UserQuestionRoom::getDataUserQuestionRoom($isInOngoingRoom->room_id);
            $isAnswered = $dataOngoingRoom->whereNotNull('is_correct')->whereNotNull('answer_option')->first();
            if($isAnswered){
                // return to leaderboard if question already answered
                return redirect()->route('question.leaderboard',[
                    'room' => $isAnswered->room->code, 
                    'order' => $isAnswered->order
                ])->with('error', 'You already in a ongoing room!');
            }
            if($isAnswered->order !== 10){
                // return to view question if question not answered yet
                return redirect()->route('question.view', [
                    'room' => $isAnswered->room->code, 
                    'order' => $isAnswered->order + 1
                ])->with('error', 'You already in a ongoing room!');
            }
        }

        $code = Room::getCode(); // Generate random code
        $slugId = Quiz::getQuizSlug($slug); // Get Quiz from slug
        
        $dataRoom = [
            'quiz_id' => $slugId->id,
            'code' => $code,
            'status' => 'waiting'
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
        $protectOngoingMethod = Room::protectOngoingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        
        if($protectOngoingMethod || $protectDoneMethod){

            return redirect()->route('index');
        }

        $room = Room::getRoomByCode($code);
        $quizId = $room->quiz_id;
        $currentTime = Carbon::now();
        $leaderboardTime = 10;

        // Check total player in a room
        $countPlayer = RoomUser::getAllWaitingPlayer($code)->count();
        if($countPlayer < 2){
            // if total player < 2
            return back();
        }

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
        Room::updateOngoingRoom($code, $dataRoomUser);
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
        $protectWaitingMethod = Room::protectWaitingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
        
        if(($protectWaitingMethod || $protectDoneMethod) && !$isInOngoingRoom){
            return redirect()->route('index');
        }
        
        $room = Room::getRoomByCode($code);
        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        if(!$savedDataOrder && intval($order) !== 1){
            return redirect()->route('question.view', [
                'room' => $code,
                'order' => 1
            ]);
        }elseif(intval($order) > 1){
            $accessibleOrder = $savedDataOrder->order + 1;
            if(intval($order) != $accessibleOrder){
                // User can't move to another order by changing the question order on URL
                return redirect()->route('question.view', [
                    'room' => $code,
                    'order' => $accessibleOrder
                ]);
            }
        }elseif(intval($order) <= 1 && $savedDataOrder){
            $accessibleOrder = $savedDataOrder->order + 1;
            return redirect()->route('question.view', [
                'room' => $code,
                'order' => $accessibleOrder
            ]);
        }

        // $allRank = RoomUser::getAllRank($room->id);
        $roomUser = RoomUser::getPlayerCurrentRoomData($room->id);
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        
        $currentTime = Carbon::now();
        $timeLeftForQuestion = (strtotime($roomQuestion->time_start) + $roomQuestion->question->timer) - strtotime($currentTime);
        
        if($timeLeftForQuestion < -300){
            // if leave the game for 5 minute
            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

            $dataRoomUser = [
                'rank' => $rank,
                'status' => 'done'
            ];
            RoomUser::updateRoomUserByUserId($code, $dataRoomUser);  

            return redirect()->route('index');
        }
        
        return view('quiz', compact('roomUser', 'roomQuestion', 'code', 'order', 'timeLeftForQuestion'));
    }

    public function joinRoomWithLink($code){  
        /* 
            Method ini dipanggil ketika User memasukkan link kedalam URL 
        */
        
        $room = Room::getRoomByCode($code);
        if(!$room){
            return redirect()->route('index');
        }
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            return redirect()->route('index');
        }
        
        return redirect()->route('room.pre-waiting-player', $room->code);
    }

    public function joinRoomWithCode(CodeRequest $request){  
        /* 
            Method ini dipanggil ketika USER menginput CODE Room
            Jika merujuk ke desain method ini akan di panggil ketika 
            user menekan tombol Gabung setelah menginput data kode room 
        */
        $room = Room::getRoomByCode($request->code);
        if(!$room){
            return back()->withErrors(['code' => 'Invalid code!']);
        }
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            return redirect()->route('index');
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
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
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
            // if room doesn't exist 
            return redirect()->route('index'); 
        }

        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            return redirect()->route('index');
        }

        $isInWaitingRoom = RoomUser::isInWaitingRoom();
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
        
        if($isInWaitingRoom){
            // If already in a waiting room
            return redirect()->route('room.waiting', $isInWaitingRoom->room->code)->with('error', 'You already in a waiting room!');
        }elseif($isInOngoingRoom){
            $dataOngoingRoom = UserQuestionRoom::getDataUserQuestionRoom($isInOngoingRoom->room_id);
            $isAnswered = $dataOngoingRoom->whereNotNull('is_correct')->whereNotNull('answer_option')->first();
            
            if($isAnswered){
                if($isAnswered->order !== 10){
                    // return to view question if question not answered yet, as long as the order not 10
                    return redirect()->route('question.view', [
                        'room' => $isAnswered->room->code, 
                        'order' => $isAnswered->order + 1
                        ])->with('error', 'You already in a ongoing room!');
                    }
                    
                // return to leaderboard if question already answered
                return redirect()->route('question.leaderboard',[
                    'room' => $isAnswered->room->code, 
                    'order' => $isAnswered->order
                ])->with('error', 'You already in a ongoing room!');
            }
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
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
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
        $protectOngoingMethod = Room::protectOngoingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        
        if($protectOngoingMethod || $protectDoneMethod){

            return redirect()->route('index');
        }
        
        $room = Room::getRoomByCode($code);
        $host = RoomUser::isHost($code);
        $player = RoomUser::isPlayer($code);
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
        $protectWaitingMethod = Room::protectWaitingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        
        if($protectWaitingMethod || $protectDoneMethod){

            return redirect()->route('index');
        }

        $room = Room::getRoomByCode($code);        
        $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentPoint = RoomUser::getPlayerCurrentRoomData($room->id)->points;
        $currentTotalCorrect = RoomUser::getPlayerCurrentRoomData($room->id)->total_correct;
        $currentAnswer = is_null($request->answer_option) ? "option_5" : $request->answer_option;
        
        if($questionId->question->answer === $currentAnswer){
            // If answer correct
            $point = ($questionId->question->timer/$questionId->question->timer) * 1000;
            
            $dataUserQuestionRoom = [
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'question_id' => $questionId->id,
                'order' => $order,
                'point' => $currentPoint + $point,
                'answer_option' => $currentAnswer,
                'is_correct' => true,
            ];
            UserQuestionRoom::create($dataUserQuestionRoom);

            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

            $dataRoomUser = [
                'rank' => $rank,
                'points' => $currentPoint + $point,
                'total_correct' => $currentTotalCorrect + 1
            ];
            RoomUser::updateRoomUserByUserId($code, $dataRoomUser);   
        }else{
            // If answer wrong
            $dataUserQuestionRoom = [
                'user_id' => Auth::user()->id,
                'room_id' => $room->id,
                'question_id' => $questionId->id,
                'order' => $order,
                'point' => $currentPoint + 0,
                'answer_option' => $currentAnswer,
                'is_correct' => false,
            ];
            UserQuestionRoom::create($dataUserQuestionRoom);

            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

            $dataRoomUser = [
                'rank' => $rank,
                'points' => $currentPoint + 0,
            ];
            RoomUser::updateRoomUserByUserId($code, $dataRoomUser);   
        }
        
        // return redirect()->route('question.leaderboard', ['room' => $code, 'order' => $order]);
        return response()->json([
            'room' => $code,
            'order' => $order
        ]);
    }

    public function leaderboard($code, $order){
        $protectWaitingMethod = Room::protectWaitingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
     
        if($protectWaitingMethod && $isInOngoingRoom && $protectDoneMethod){

            return redirect()->route('index');
        }

        $room = Room::getRoomByCode($code);

        $roomUser = RoomUser::getTop5Rank($room->id);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        
        if(intval($order) === $totalQuestion){
            $timeLeftForLeaderboard = 0;
            $final = true;
            return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard'));
        }elseif(intval($order) != $savedDataOrder->order){
            // User can't move to another order by changing the question order on URL
            return back();
        }
        
        $currentTime = Carbon::now();
        $final = false;
        $timeLeftForLeaderboard = strtotime($roomQuestion->time_end) - strtotime($currentTime);
        
        return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard'));
    }

    public function exitGame($code){
        $room = Room::getRoomByCode($code);

        $protectDoneMethod = Room::protectDoneMethod($code);
        $authUserIsDone = RoomUser::isDone($room->id);
        $userIsInDoneRoom = RoomUser::userIsInDoneRoom($room->id);
        
        if($protectDoneMethod && $userIsInDoneRoom && $authUserIsDone){
            return redirect()->route('index');
        }

        $dataRoomUser = [
            'status' => 'done',
        ];
        $roomUser = RoomUser::updateDoneRoomUser($code, $dataRoomUser);

        $host = RoomUser::isHost($code);
        
        if($host){
            $dataRoom = [
                'status' => 'done',
            ];
            Room::updateDoneRoom($code, $dataRoom);
        }
        
        $roomUser = $room->roomusers->first();
        $quiz = Quiz::where('id', $roomUser->room->quiz_id)->first();
        $dataQuiz = [
            'counter' => $quiz->counter + 1,
        ];
        Quiz::where('id', $roomUser->room->quiz_id)->update($dataQuiz);
        
        return redirect()->route('index');
    }
}
