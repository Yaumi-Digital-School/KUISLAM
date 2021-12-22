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

    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public static function getRank($roomId, $order){
        return UserQuestionRoom::where('room_id', $roomId)->where('order', $order)->get()->SortByDesc('point');
    }
}
