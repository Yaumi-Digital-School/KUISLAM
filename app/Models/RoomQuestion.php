<?php

namespace App\Models;

use App\Models\Room;
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

    public static function deleteRoomQuestion($code){
        $room = Room::getRoomByCode($code);
        return RoomQuestion::where('room_id', $room->id)->delete();
    }
}
