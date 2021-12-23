<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomQuestion extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

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

    public static function getQuestionByRoomIdAndOrder($roomId, $order){
        return RoomQuestion::where('room_id', $roomId)->where('order', $order)->first();
    }

    public static function autoIncrement()
    {
        // Start a loop
        for ($i = 0; $i <= 10; $i++) {
            // Yield the current value of $i
            yield $i;
            // If $i is equal to 10, that must mean the start of a new loop
            if($i == 10) {
                // Reset $i to 0 to start over.
                $i = 0;
            }
        }
    }
}
