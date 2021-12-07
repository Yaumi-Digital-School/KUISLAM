<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function deleteRoomQuestion($code){
        $room = Room::getRoomByCode($code);
        return RoomQuestion::where('room_id', $room->id)->delete();
    }
}
