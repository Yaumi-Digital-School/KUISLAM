<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsWaiting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($next($request));
        // $code = substr($request->decodedPath(),6,6);
        // $room = Room::getRoomByCode($code);
        // $waiting = RoomUser::where('user_id', Auth::id())->where('room_id', $room->id)->where('status', 'waiting')->first();
        // $ongoing = RoomUser::where('user_id', Auth::id())->where('status', 'ongoing')->first();
        // $done = RoomUser::where('user_id', Auth::id())->where('status', 'done')->first();
        // if($waiting){
        //     return $next($request);
        // }elseif($ongoing){
        //     return redirect()->route('index');
        // }
    }
}
