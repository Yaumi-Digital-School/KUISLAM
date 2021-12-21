<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leaderboard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCurrentPoint(){
        return Leaderboard::where('user_id', Auth::user()->id)->first();
    }

    public static function getAllLeaderboard(){
        return Leaderboard::all()->sortByDesc('point');
    }
}
