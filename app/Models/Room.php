<?php

namespace App\Models;

use App\Models\RoomQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function roomquestions()
    {
        return $this->hasMany(RoomQuestion::class);
    }
}
