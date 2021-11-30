<?php

namespace App\Http\Controllers;

use App\Models\RoomUser;
use Illuminate\Http\Request;

class RoomUserController extends Controller
{
    public function createRoomUser($data){
        return RoomUser::insert($data);
    }
}
