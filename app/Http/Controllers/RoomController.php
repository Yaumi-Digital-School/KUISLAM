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

use function PHPUnit\Framework\returnValueMap;

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
            
            if(!$isAnswered){
                return redirect()->route('question.leaderboard',[
                    'room' => $isInOngoingRoom->room->code, 
                    'order' => 1
                ])->with('error', 'You already in a ongoing room!');
            }elseif($isAnswered){
                // return to leaderboard if question already answered
                return redirect()->route('question.leaderboard',[
                    'room' => $isAnswered->room->code, 
                    'order' => $isAnswered->order
                ])->with('error', 'You already in a ongoing room!');
            }elseif($isAnswered->order != 10){
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
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
        // dd($questionsId[0]->id);

        for($i = 0; $i < 10; $i++){
            $dataRoomQuestion = [
                'question_id' => $questionsId[$i]->id,
                'room_id' => $room->id,
                'order' => $i+1,
            ];
            $roomQuestion = RoomQuestion::create($dataRoomQuestion);

            $tempRoomQuestion = RoomQuestion::getRoomQuestionById($room->id);
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

            $dataRoomQuestion = [
                'time_start' => $timeStartDate,
                'time_end' => $timeEndDate,
            ];
            RoomQuestion::updateQuestionByRoomIdAndOrder($room->id,  $i+1, $dataRoomQuestion);        
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
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
        }
        
        $room = Room::getRoomByCode($code);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);

        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        if($savedDataOrder && $savedDataOrder->order == $totalQuestion){
            return redirect()->route('question.leaderboard', [
                'room' => $code,
                'order' => $savedDataOrder->order
            ]);
        }elseif(!($order >= 1 && $order <= $totalQuestion)){
            // if order not between 1 - 10
            return back();
        }

        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentTime = Carbon::now();
        $timeLeftForQuestion = (strtotime($roomQuestion->time_start) + $roomQuestion->question->timer) - strtotime($currentTime);
        $timeLeftForLeaderboard = strtotime($roomQuestion->time_end) - strtotime($currentTime);
        
        if($order == 1){
            if(!$savedDataOrder){
                if($timeLeftForQuestion < 1){
                    $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);

                    $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

                    // data to be inserted (default is wrong answer)
                    $dataUserQuestionRoom = [
                        'user_id' => Auth::user()->id,
                        'room_id' => $room->id,
                        'question_id' => $questionId->question_id,
                        'order' => $order,
                        'point' => 0,
                        'answer_option' => 'option_5',
                        'is_correct' => false,
                    ];
                    $dataRoomUser = [
                        'rank' => $rank,
                    ];
                    UserQuestionRoom::create($dataUserQuestionRoom);
                    RoomUser::updateRoomUserByUserId($code, $dataRoomUser);
                    
                    return redirect()->route('question.leaderboard', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }
            }elseif($savedDataOrder){
                $accessibleOrder = $savedDataOrder->order + 1;
                if($timeLeftForQuestion < 1){
                    // if recent order is not 1 and change order to 1, answered, time is up
                    // ceklis
                    // dd('anda tidak boleh mundur karena waktu pada order 1 telah habis!');
                    return redirect()->route('question.view', [
                        'room' => $code,
                        'order' => $accessibleOrder
                    ]);
                }
            }
        }elseif($order != 1){
            if(!$savedDataOrder){
                $accessibleOrder = 1;
                if($timeLeftForQuestion > 1){
                    // if recent order is 1 and change order other than 1, not answer, there is time left
                    // Ceklis
                    // dd('anda tidak boleh maju karena masih order 1 belum jawab dan waktu masih ada!');
                    return redirect()->route('question.view', [
                        'room' => $code,
                        'order' => $accessibleOrder
                    ]);
                }              
            }elseif($savedDataOrder){
                $accessibleOrder = $savedDataOrder->order + 1;
                if($savedDataOrder->order == 1){
                    if($timeLeftForQuestion > $roomQuestion->question->timer){
                        // if recent order 1, answered, there is time left
                        // Ceklis
                        // dd($timeLeftForQuestion > $roomQuestion->question->timer);
                        // dd('anda tidak boleh maju, walau sudah jawab tapi masih ada waktu tersisa!');
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => 1
                        ]);
                    }
                }elseif($order != $accessibleOrder){
                    if($timeLeftForQuestion > $roomQuestion->question->timer){
                        // order cant go forward
                        // ceklis
                        // dd('anda tidak boleh maju karena belum jawab bawah!');
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => $accessibleOrder
                        ]);
                    }elseif($timeLeftForQuestion < 1){
                        // order cant go backward
                        // ceklis
                        // dd('anda tidak boleh mundur karena belum jawab!');
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => $accessibleOrder
                        ]);
                    }
                }elseif($order == $accessibleOrder){
                    if($timeLeftForQuestion > $roomQuestion->question->timer){
                        // order cant go forward
                        // ceklis
                        // dd('anda tidak boleh maju walau sudah jawab tapi masih ada waktu tersisa!');
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => $accessibleOrder - 1
                        ]);
                    }elseif($timeLeftForQuestion < 1){       
                        $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);

                        $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

                        // data to be inserted (default is wrong answer)
                        $dataUserQuestionRoom = [
                            'user_id' => Auth::user()->id,
                            'room_id' => $room->id,
                            'question_id' => $questionId->question_id,
                            'order' => $order,
                            'point' => 0,
                            'answer_option' => 'option_5',
                            'is_correct' => false,
                        ];
                        $dataRoomUser = [
                            'rank' => $rank,
                        ];
                        UserQuestionRoom::create($dataUserQuestionRoom);
                        RoomUser::updateRoomUserByUserId($code, $dataRoomUser);
                        
                        return redirect()->route('question.leaderboard', [
                            'room' => $code,
                            'order' => $savedDataOrder->order
                        ]);                        
                    }
                }
            }
        }elseif($order <= 1 && !($order > $totalQuestion) && $savedDataOrder && $timeLeftForQuestion > $roomQuestion->question->timer){
            // prevent user change data order less than 1 when user recent order is more than 1
            $accessibleOrder = $savedDataOrder->order + 1;
            return redirect()->route('question.view', [
                'room' => $code,
                'order' => $accessibleOrder
            ]);
        }

        $roomUser = RoomUser::getPlayerCurrentRoomData($room->id);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        
        // if user already submit the question 
        if(UserQuestionRoom::where('user_id', Auth::id())
                                    ->where('room_id', $room->id)
                                    ->where('question_id', $roomQuestion->question->id)
                                    ->exists() && $timeLeftForQuestion > 1){
            $user_answer = UserQuestionRoom::where('user_id', Auth::id())
                                    ->where('room_id', $room->id)
                                    ->where('question_id', $roomQuestion->question->id)
                                    ->get()->first()->answer_option;
            // dd("hehe");
            return view('quiz', compact('roomUser', 'roomQuestion', 'code', 'order', 'timeLeftForQuestion', 'user_answer'));
        }

        if($timeLeftForQuestion < -300){
            // if leave the game more than 5 minute
            $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);
            $isHost = RoomUser::isHost($code);
            if($isHost){
                $dataRoom = [
                    'status' => 'done'
                ];
                Room::updateDoneRoom($code, $dataRoom); 
            }

            $dataRoomUser = [
                'rank' => $rank,
                'status' => 'done'
            ];
            RoomUser::updateRoomUserByUserId($code, $dataRoomUser);  

            $message = "leave-5-minute";
            return redirect()->route('index.redirect', $message);
        }
        return view('quiz', compact('roomUser', 'roomQuestion', 'code', 'order', 'timeLeftForQuestion'));
    }

    public function joinRoomWithLink($code){  
        /* 
            Method ini dipanggil ketika User memasukkan link kedalam URL 
        */
        
        $room = Room::getRoomByCode($code);
        if(!$room){
            $message = "room-not-exist";
            return redirect()->route('index.redirect', $message);
        }
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
            $message = "room-not-exist";
            return redirect()->route('index.redirect', $message);
        }
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
            $message = "room-not-exist";
            return redirect()->route('index.redirect', $message);
        }

        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
        }

        $isInWaitingRoom = RoomUser::isInWaitingRoom();
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
        
        if($isInWaitingRoom){
            // If already in a waiting room
            return redirect()->route('room.waiting', $isInWaitingRoom->room->code)->with('error', 'You already in a waiting room!');
        }elseif($isInOngoingRoom){
            $dataOngoingRoom = UserQuestionRoom::getDataUserQuestionRoom($isInOngoingRoom->room_id);
            $isAnswered = $dataOngoingRoom->whereNotNull('is_correct')->whereNotNull('answer_option')->first();
            
            if(!$isAnswered){
                return redirect()->route('question.leaderboard',[
                    'room' => $isInOngoingRoom->room->code, 
                    'order' => 1
                ])->with('error', 'You already in a ongoing room!');
            }elseif($isAnswered){
                if($isAnswered->order != 10){
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

        $room = Room::getRoomByCode($code);
        if(!$room){
            $message = "room-not-exist";
            return redirect()->route('index.redirect', $message); 
        }
        
        $protectOngoingMethod = Room::protectOngoingMethod($room->code);
        $protectDoneMethod = Room::protectDoneMethod($room->code);
        
        if($protectOngoingMethod || $protectDoneMethod){
            // if room status is ongoing OR done
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
        }
        
        /* 
            Yang tidak terdaftar dalam suatu room tidak bisa masuk
        */
        $isInRoom = RoomUser::isInRoom($code);
        if(!$isInRoom){
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);   
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
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
        }

        $room = Room::getRoomByCode($code);        
        $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentPoint = RoomUser::getPlayerCurrentRoomData($room->id)->points;
        $currentTotalCorrect = RoomUser::getPlayerCurrentRoomData($room->id)->total_correct;
        $currentAnswer = $request->answer_option;
        $timer = $request->timer;

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
            $point = ($timer/$questionId->question->timer) * 1000;

            $dataUserQuestionRoom['point'] = $currentPoint + $point;
            $dataUserQuestionRoom['is_correct'] = true;

            $dataRoomUser['points'] = $currentPoint + $point;
            $dataRoomUser['total_correct'] = $currentTotalCorrect + 1;
        }
        UserQuestionRoom::create($dataUserQuestionRoom);
        RoomUser::updateRoomUserByUserId($code, $dataRoomUser);   
        return response()->json([
            'room' => $code,
            'order' => $order,
            'user_answer' => $currentAnswer
        ]);
    }

    public function leaderboard($code, $order){
        /* 
            Method ini untuk menampilkan Leaderboard
        */
        $protectWaitingMethod = Room::protectWaitingMethod($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        $isInOngoingRoom = RoomUser::isInOngoingRoom();
     
        if($protectWaitingMethod && $isInOngoingRoom && $protectDoneMethod){
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
        }

        $room = Room::getRoomByCode($code);
        $totalQuestion = RoomQuestion::getTotalQuestionsInRoom($room->id);
        $savedDataOrder = UserQuestionRoom::getSavedDataOrder($room->id)->first();
        
        if(!($order >= 1 && $order <= $totalQuestion)){
            return back();
        }
        
        $roomUser = RoomUser::getTop5Rank($room->id);
        $roomQuestion = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);
        $currentTime = Carbon::now();
        $timeLeftForQuestion = (strtotime($roomQuestion->time_start) + $roomQuestion->question->timer) - strtotime($currentTime);
        $timeLeftForLeaderboard = strtotime($roomQuestion->time_end) - strtotime($currentTime);
        $isCorrect = UserQuestionRoom::where('room_id', $room->id)->where('user_id', Auth::id())->where('order', $order)->first();

        if(!$isCorrect){
            if($order == 1){
                // if not answer when order == 1
                if($timeLeftForQuestion > 1){
                    return redirect()->route('question.view', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }elseif($timeLeftForQuestion < 1){
                    $questionId = RoomQuestion::getQuestionByRoomIdAndOrder($room->id, $order);

                    $rank = UserQuestionRoom::getAuthUserRank($room->id, $order);

                    // data to be inserted (default is wrong answer)
                    $dataUserQuestionRoom = [
                        'user_id' => Auth::user()->id,
                        'room_id' => $room->id,
                        'question_id' => $questionId->question_id,
                        'order' => $order,
                        'point' => 0,
                        'answer_option' => 'option_5',
                        'is_correct' => false,
                    ];
                    $dataRoomUser = [
                        'rank' => $rank,
                    ];
                    UserQuestionRoom::create($dataUserQuestionRoom);
                    RoomUser::updateRoomUserByUserId($code, $dataRoomUser);
                    
                    return redirect()->route('question.leaderboard', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }
            }
            // if not answer when order > 1 < 10
            return redirect()->route('question.view', [
                'room' => $code,
                'order' => 1
            ]);
        }elseif($isCorrect->is_correct == 1){
            $isCorrect = true;
        }else{
            $isCorrect = false;
        }
        
        if($savedDataOrder->order == 10 && $timeLeftForQuestion < 1){
            $timeLeftForLeaderboard = 0;
            $final = true;
            $roomUser = Question::getAllRank($room->id);
            return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard', 'isCorrect'));
        }elseif($order == 1){
            if(!$savedDataOrder){
                if($timeLeftForQuestion < 1){
                    // if order 1, not answered, there's no time to choose an answer
                    // dd('if order 1, not answered, time is up');
                    return redirect()->route('question.handle', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }elseif($timeLeftForQuestion > 1){
                    // if order 1, not answered, there's time to choose an answer
                    // MENAMPILKAN QUIZ PERTAMA
                    // dd('if order 1, not answered, there is time left');
                    return redirect()->route('question.view', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }
            }elseif($savedDataOrder){
                //if recent order is not 1 but go to other order
                $accessibleOrder = $savedDataOrder->order + 1;
                if($savedDataOrder->order != 1 && $timeLeftForQuestion < 1){
                    // order cant go backward
                    //ceklis
                    // dd('anda tidak boleh mundur karena waktu pada order 1 telah habis!');
                    return redirect()->route('question.leaderboard', [
                        'room' => $code,
                        'order' => $accessibleOrder
                    ]);
                }elseif($savedDataOrder->order == 1 && $timeLeftForQuestion > 1){
                    return redirect()->route('question.view', [
                        'room' => $code,
                        'order' => 1
                    ]);
                }
            }
        }elseif($order != 1){
            if($savedDataOrder){
                // prevent user change data order when user recent order is 1
                $accessibleOrder = $savedDataOrder->order + 1;
                if($order != $accessibleOrder){
                    if($timeLeftForLeaderboard < 1){
                        // User can't move to another order by changing the question order on URL
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => $accessibleOrder
                        ]);
                    }elseif($timeLeftForQuestion > 1){
                        // if recent order is not 1, answered, there is time left
                        //ceklis
                        // dd('if recent order is not 1, answered, there is time left');
                        return redirect()->route('question.view', [
                            'room' => $code,
                            'order' => $savedDataOrder->order
                        ]);
                    }
                }
            }
        }elseif($order <= 1 && $savedDataOrder && $timeLeftForLeaderboard < 1){
            // prevent user change data order less than 1 when user recent order is more than 1
            $accessibleOrder = $savedDataOrder->order + 1;
            return redirect()->route('question.view', [
                'room' => $code,
                'order' => $accessibleOrder
            ]);
        }
        
        $final = false;        
        return view('leaderboard', compact('roomUser', 'final', 'order', 'code', 'timeLeftForLeaderboard', 'isCorrect'));
    }

    public function exitGame($code){
        $room = Room::getRoomByCode($code);
        $protectDoneMethod = Room::protectDoneMethod($code);
        $userIsInDoneRoom = RoomUser::userIsInDoneRoom($room->id);
        // $authUserIsDone = RoomUser::isDone($room->id);
        
        if($protectDoneMethod && $userIsInDoneRoom){
            $message = "room-cant-access";
            return redirect()->route('index.redirect', $message);
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
        $quiz = Quiz::getQuizId($roomUser->room->quiz_id);
        $dataQuiz = [
            'counter' => $quiz->counter + 1,
        ];
        Quiz::updateQuiz($roomUser->room->quiz_id, $dataQuiz);
        
        return redirect()->route('index');
    }
}
