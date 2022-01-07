<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuestionRoom extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getSortByDescRank($roomId, $order){
        return UserQuestionRoom::where('room_id', $roomId)->where('order', $order)->get()->SortByDesc('point');
    }

    public static function getSavedDataOrder($roomId){
        return UserQuestionRoom::where('user_id', Auth::user()->id)->where('room_id', $roomId)->get()->SortByDesc('order');
    }

    public static function getDataUserQuestionRoom($roomId){
        return UserQuestionRoom::where('user_id', Auth::user()->id)->where('room_id', $roomId)->get()->SortByDesc('order');
    }
    
    public static function getAuthUserRank($roomId, $order){
        $dataRank = UserQuestionRoom::getSortByDescRank($roomId, $order);
        for($i = 0; $i < count($dataRank); $i++){
            if($dataRank[$i]->user_id === Auth::user()->id){
                return $i + 1;
            }
        }
    }
}
